<?php

namespace App\Http\Controllers;

use App\User;
use App\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $image = Auth::user()->userImage;
        $books = Auth::user()->books()->whereNull('deleted_at')->get();
        return view('home', compact('image','books'));
    }

    public function edit()
    { 
        $user = User::findOrFail(Auth::user()->id);
        return view('users.change_password', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $image = request('image');

        if($image) {
            $attributes = $this->validateImage();

            //Create image
            $imageName = 'user_image_' . time() . '.' . $request->image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath())->orientate();
            $image_resize->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            if(!$image_resize->save(public_path('images/users/' . $imageName))) 
                return back()->with('error', 'Image upload problem.');

         	//Delete old image if exists
         	$default_image = 'images/users/default_no_user.png';
         	if($user->userImage && File::exists(public_path() . '/' . $user->userImage->image) && $user->userImage->image != $default_image)
        		File::delete(public_path() . '/' . $user->userImage->image);

	        //Update DB with new image
	        UserImage::updateOrCreate(['user_id' => Auth::user()->id],
	        	['image' => 'images/users/' . $imageName]
         	);
     
          	return redirect ('/home')->with('success','Image changed successfuly.');

       	} else {
       		return redirect ('/home')->with('error','Error while changing image!');
       	}
    }

    protected function validateImage()
    {
        return request()->validate([
            'image'  => ['image','mimes:jpeg,png,jpg,gif,svg','max:8192',
                        'dimensions:min_width=200,min_height=300',
                        'dimensions:max_width=3000,max_height=4000'],
        ]);
    }
}
