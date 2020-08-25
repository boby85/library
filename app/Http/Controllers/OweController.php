<?php

namespace App\Http\Controllers;

use App\Book;
use App\Owe;
use Illuminate\Http\Request;

class OweController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $owes = Owe::leftjoin('books','owes.book_id', '=', 'books.id')
            ->leftjoin('users','owes.user_id', '=', 'users.id')
            ->select('owes.id as oweId', 'owes.created_at as oweDate', 'books.id as bookId','books.title','users.id as userId','users.name')
            ->get();

        return view('owes.index', compact('owes'));
    }

    public function store(Request $request, Book $book)
    {
        $book_id = (int)(request('book'));
             
        $book_available = Book::where('id', '=', $book_id)
                ->pluck('available')
                ->first();
        
        if($book_available > 0) {

            $user_id = request('member');
    
                if($user_id == NULL || $user_id == '' || $user_id == 0) {
                    return back()->with('error', 'Please select user.');   
                }
    
                if($this->isRentedByUser($user_id, $book_id)) {
                    return back()->with('error', 'User rented this book already!');
                } 
                else    
                {
                    Owe::create([
                        'user_id' => $user_id,
                        'book_id' => $book_id,
                    ]);
    
                    Book::where('id', $book_id)
                            ->decrement('available');
    
                    return redirect('/books')->with('success','Book rented successfully.');;
            }    
        } else {
            return back()->with('error', 'Book not available.'); 
        }
        
    }

    public function destroy($owe)
    {
        $return_book = Owe::findOrFail((int)($owe));
        $return_book->delete();

        Book::where('id', '=', $return_book['book_id'])
                ->increment('available');

        return redirect('/owes')->with('success','Book returned successfully.');;
    }

    protected function isRentedByUser($userId, $bookId)
    {
        if (Owe::where('user_id', '=', $userId)
                ->where('book_id', '=', $bookId)
                ->count()) {
            return true;
        }
        return false;
    }
}
