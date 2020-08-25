@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="book-cover-image col-sm-auto">
            <img src="/{{ $image->image ?? 'images/covers/default_no_cover.jpg' }}" class="{{ ($image->image) ?? 'thumbnail' }}" alt="book cover">
            <h6 class="book-isbn" data-isbn="{{ $book->isbn ?? ''}}"><b>ISBN: </b>{{ $book->isbn ?? '-'}} </h6>
        </div>
        
        <div class="col-sm">
            <h2 class="book-title" data-title="{{ $book->title }}">{{ $book->title }}</h2>
            <h5 class="book-author" data-author="{{ $book->author }}">by {{ $book->author }}</h5>
            <div>
                <p>{{ $book->note ?? ''}}</p>
            </div>
            <div>
                @if ($book->available > 0)
                    <div class="book-available-title">
                        Available: {{ $book->available }}
                    </div>
                @else
                    <div class="book-unavailable-title">
                        Book not available: {{ $book->available }}
                    </div>
                @endif
                <a class="btn btn-primary button is-link button-edit" href = "/books/{{ $book->id }}/edit"> Edit details</a>    
            </div>
            @if ($book->available > 0 && $users->count() > 0)
                <div class="select-user-book-rent-title">
                    Select user for book rental:
                </div>
                <div class="form-book-rent">
                    <form method="POST" action="/owes" accept-charset="utf-8">
                        @csrf
                        <select name="member" class="form-control select-user" >
                            
                            
                            @foreach($users as $user)   
                                <option value="{{ $user->id }}" title="{{ $user->email }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="book" value="{{ $book->id }}">
                        <div class="field">     
                            <div class="control">
                                <button type="submit" class="btn btn-primary button is-link button-rent">Rent book</button>
                            </div>
                        </div>
                    </form>
                </div>

                <script>
                $(document).ready(function() {
                    $('.select-user').select2();
                });

                var title = $('.book-title').data('title');
                var isbn = $('.book-isbn').data('isbn');
                var author = $('.book-author').data('author');
                var searchQuery = 'title:' + title + '&author' + author;
                if(isbn)
                    searchQuery = 'isbn:' + isbn;

                $.ajax({
                    dataType: 'json',
                    url: 'https://www.googleapis.com/books/v1/volumes?q=' + searchQuery + '&maxResults=1',
                    success: handleResponse
                });

                function handleResponse( response ) {
                    $.each( response.items, function( i, item ) {
                    
                        if(item.volumeInfo.imageLinks) {
                            var thumb = item.volumeInfo.imageLinks.thumbnail;
                            $('.thumbnail').attr('src', thumb);
                        }
                    });
                }
                </script>
            @endif
        </div>
    </div>
</div>
	
@endsection