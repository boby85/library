<?php

namespace App\Http\Controllers;

use App\Book;
use App\CoverImage;
use App\Owe;
use App\Rules\ISBN;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request, Book $book)
    {
        $attributes = $this->validateBook($bookId = null);
        $attributes['available'] = request('copies');
		
		$book = Book::create($attributes);

		if(request('image')) { 
			$imageName = $this->createCoverImage(request('image'));
			CoverImage::create([
				'book_id' => $book->id,
				'image' => 'images/covers/' . $imageName
			]);
		}
        return redirect ('/books')->with('success','Book added successfully.'); 
    }

    public function show(Book $book)
    {
        $users = User::where('role', '3')->get();
        $image = Book::find($book->id)->coverImage;  
        return view('books.show', compact('book','users','image'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $bookId = $book->id;
        $attributes = $this->validateBook($bookId);
        $copies_current = $book->copies;
        $copies_new = request('copies');
        $copies_rented = $copies_current - $book->available;

        if($copies_new == 0) {
            return back()->with('error', 'Copies can\'t be zero!');
        } else if($copies_new < $copies_rented) {
            return back()->with('error', 'Copies must me greater or equal to the number or rented books');
        } else {
            $attributes['available'] = $copies_new - $copies_rented;
            
			if(request('image')) {
				$imageName = $this->createCoverImage(request('image'));
				if($book->coverImage()) {
					if(File::exists(public_path() . '/' . $book->coverImage()->image)) 
						File::delete(public_path() . '/' . $book->coverImage()->image);
				}
				CoverImage::updateOrCreate(['book_id'=> $book->id],
					['image' => 'images/covers/' . $imageName]
				);
			}         
            $book->update($attributes);

            return redirect ('/books/'.$book->id)->with('success','Book changed successfully.');
        }
    }

	public function destroy(Book $book)
	{
		if(!Owe::where('book_id', $book->id)->count()) { // Book is not rented it is safe to delete
			if($book->coverImage()) { // Cover exists, delete it
				if(File::exists(public_path() . '/' . $book->coverImage->image)) 
					File::delete(public_path() . '/' . $book->coverImage->image);        
			}
			$book->delete();
			return redirect ('/books')->with('success','Book deleted successfully.');

		} else {
			return redirect('/books/' . $book->id)->with('error', 'Book can\'t be deleted if rented! Return the book, and try again.');
		}
	}

    protected function validateBook($bookId)
    {
        return request()->validate([
        	'isbn'	=> ['required', 'numeric', new ISBN, Rule::unique('books')->ignore($bookId)],
            'title' => ['required', 'min:3'],
            'author'=> ['required', 'min:3'],
            'copies'=> ['required', 'numeric','between:1,100'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:8192',
                        'dimensions:min_width=128, min_height=192',
                        'dimensions:max_width=3000, max_height=4000'],
            'note'	=>	['max:2000']
        ]);
    }

    protected function createCoverImage($image)
	{
		$imageName = 'cover_image_' . time() . '.' . $image->getClientOriginalExtension();
		$image_resize = Image::make($image->getRealPath());
		$image_resize->resize(128, null, function ($constraint) {
			$constraint->aspectRatio();
		});
		if(!$image_resize->save(public_path('images/covers/' . $imageName)))
		{
			return back()->with('error', 'Image upload problem.');
		} else {
			return $imageName;
		}
	}
}