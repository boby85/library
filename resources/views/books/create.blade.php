@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add new Book') }}</div>

                <div class="card-body">
                    <form method="POST" action="/books" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="isbn" class="col-md-4 col-form-label text-md-right">{{ __('ISBN') }}</label>
                            <div class="col-md-6">
                                <input id="isbn" type="numeric" class="book-isbn form-control @error('isbn') is-invalid @enderror" name="isbn" value="{{ old('isbn') }}" required autofocus placeholder="Search by ISBN...">
                                @error('isbn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

						<div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus placeholder="Book title">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="author" class="col-md-4 col-form-label text-md-right">{{ __('Author') }}</label>
                            <div class="col-md-6">
                                <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') }}" required autocomplete="author" autofocus placeholder="Author">
                                @error('author')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="copies" class="col-md-4 col-form-label text-md-right">{{ __('Copies') }}</label>
                            <div class="col-md-6">
                                <input id="copies" type="number" class="form-control @error('copies') is-invalid @enderror" name="copies" value="{{ old('copies') }}" required autocomplete="copies" autofocus placeholder="Copies">
                                @error('copies')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Cover photo') }}</label>
                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" autofocus placeholder="Cover photo">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="note" class="col-md-4 col-form-label text-md-right">{{ __('Note') }}</label>
                            <div class="col-md-6">
                                <textarea id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" autocomplete="note" autofocus placeholder="Note...">{{ old('note') }}</textarea>
                                @error('note')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>               	
                    </form>
            	</div>               
        	</div>
    	</div>
	</div>
</div>

<script>
    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

    $('#isbn').keyup(delay(function(e) {
        var isbn = $('#isbn').val();
        if(isbn){
            $.ajax({
                dataType: 'json',
                url: 'https://www.googleapis.com/books/v1/volumes?q=isbn:' + isbn,
                success: handleResponse
            });
        }
        function handleResponse( response ) {
            $.each( response.items, function( i, item ) {         
                var title  = item.volumeInfo.title,
                    author = item.volumeInfo.authors[0],
                    note   = item.volumeInfo.description;

                $('#title').val( title );
                $('#author').val( author );
                $('#note').val( note );
            });
        }
    }, 1000));
</script>

@endsection