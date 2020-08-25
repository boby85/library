<?php

namespace App\Http\Controllers;

use App\Mail\UserCreated;
use App\User;
use App\UserImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = 3; // Normal user role, so moderator will list only normal users, not other moderators

        if($this->isAdmin())
            $role = 2;  // Moderator user role, so admin will list only moderator users
        
        $users = User::when($role, function ($query, $role) {
                    return $query->where('role', $role);
                })
                ->select('id','name','address','date_of_birth')
                ->get();            

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $attributes = $this->validateUser();
        $attributes['role'] = ($this->isAdmin()) ? 2 : 3; //If admin is logged in create moderator, otherwise create normal user
        $password_insecure = Str::random(8);
        $attributes['password'] = Hash::make($password_insecure);
        $imageName = 'default_no_user.png';

        $user = User::create($attributes);
        
        UserImage::create([
            'user_id' => $user->id,
            'image' => 'images/users/' . $imageName
        ]);
        
        Mail::to($user->email)->send(
            new UserCreated($password_insecure)
        );
      
        return redirect ('/users')->with('success','User added successfully.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $image = $user->userImage;
        return view('users.show', compact('user','image'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $image = $user->userImage; 
        return view('users.edit', compact('user', 'image'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $attributes = request()->validate([
            'name' => ['required', 'string','min:3', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'address' => ['required', 'string','min:5', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',],
            'phone' => ['required', 'string', 'min:6', 'max: 15'],            
        ]);
       
        $user->update($attributes);

        return redirect ('/users/'.$user->id)->with('success','User changed successfully.');        
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
    	
        if(!$this->userOwesBook($id)){

            if($user->userImage) {
                $image_path = public_path() . '/' . $user->userImage->image;
                if($image_path != public_path() . '/images/users/default_no_user.png'  && File::exists($image_path)) 
                    File::delete($image_path);
            }

            $user->delete();
            return redirect ('/users')->with('success','User deleted successfully.');
        } else {
            return redirect('/users')->with('error', 'User can\'t be deleted if owes book(s)! Return the book(s), and try again.');
        }
    }
    
    protected function userOwesBook($userId)
    {
        $user = User::findOrFail($userId);
        if($user->books()->where('deleted_at')->count())
            return true;

        return false;
   	}

    protected function isAdmin()
    {
        if(request()->user()->role == 1)
            return true;

        return false;
    }   

    protected function validateUser()
    {
        return request()->validate([
            'name' => ['required', 'string','min:3', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'address' => ['required', 'string','min:5', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:6', 'max: 15'],      
        ]);
    }

    public function changePassword()
    {
        $user = User::findOrFail(Auth::user()->id);
        return view('users.change_password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $attributes = request()->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
            'current_password' => ['required', 
            function ($attribute, $value, $fail) {
                if ( ! Hash::check($value, Auth::user()->password)) {
                    $fail('Current password is incorrect.');
                }
            }],
        ]);

        $user->fill(['password' => Hash::make(request('password'))])->save();
        return redirect($this->redirectPath())->with('success','Password changed successfuly.'); 

    }

    public function redirectPath()
    {
        $role = Auth::user()->role;
        
        switch($role) {
            case '1':
                return '/admin';
                break;
            case '2':
                return '/books';
                break;
            case '3':
                return '/home';
                break;
            default:
                return '/login';
                break;
        }
    }
}

