@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
	    <div class="col-md-8">
	        <div class="card">
	            <div class="card-header">{{ __('Edit Book') }}</div>

	            <div class="card-body">
	                <form method="POST" action="/books/{{ $book->id }}" enctype="multipart/form-data">
	                	@method('PATCH')
	                	@csrf

		                <div class="form-group row">
	                    	<label for="isbn" class="col-md-4 col-form-label text-md-right">{{ __('ISBN') }}</label>
		                    <div class="col-md-6">
		                    	<input id="isbn" type="text" class="form-control @error('isbn') is-invalid @enderror" name="isbn" value="{{	$book->isbn }}" required autocomplete="isbn" autofocus>		
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
	                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ 	$book->title }}" required autocomplete="title" autofocus>	
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
	                            <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ $book->author }}" required autocomplete="author" autofocus>	
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
	                            <input id="copies" type="number" class="form-control @error('copies') is-invalid @enderror" name="copies" value="{{ $book->copies }}" required autocomplete="copies" autofocus>	
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
	                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ 	old('image') }}" autofocus placeholder="Cover photo">
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
	                            <textarea id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" autocomplete="note"autofocus>{{ $book->note }}</textarea>	
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
	                                {{ __('Update') }}
	                            </button>
	                        </div>
	                    </div>     	
	                </form>    
	           	</div>
	
	            <div class="card-body">
	                <form class="delete" method="POST" action="/books/{{ $book->id }}">
	                    @method('DELETE')
	                    @csrf       
	                    <button type="submit" class="btn btn-danger">
	                        {{ __('Delete book') }}
	                    </button>
    	        	</form>
               	</div>
            </div>
       	</div>
   	</div>
</div>
<script>
    $(".delete").on("submit", function(){
        return confirm("Are you sure?");
    });
</script>
@endsection