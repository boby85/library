@extends('layouts.app-user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-auto">
                            <div class="user-image">
                                <img src="/{{ $image->image ?? 'images/users/default_no_user.png' }}" alt="user image">
                            </div>
                        <div class="user_image_select">
                            <form method="POST" action="/home/{{ Auth::user()->id }}" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                                
                                <div class="user-image-input-file">
                                    <input id="image_select-input" type="file" class="form-control @error('image') is-invalid @enderror" name="image" autofocus>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="user-image-save-button">
                                        <button id="submit-button" type="submit" class="btn btn-primary">
                                            {{ __('Save') }}
                                        </button>    
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                        </div>
                        <div class="col-sm">
                            <div class="title">
                                <h4>My rented books / Rent Date:</h4>
                            </div>

                            @if($books->count())
                                <ul>
                                    @foreach($books as $book)
                                        <li> {{ $book->title}} / {{ date('d-m-Y', strtotime($book->pivot->created_at))}} </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No rented books.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(
    function(){
        $('#submit-button').attr('disabled',true);
        $('#image_select-input').change(
            function(){
                if ($(this).val()){
                    $('#submit-button').removeAttr('disabled'); 
                }
                else {
                    $('#submit-button').attr('disabled',true);
                }
            });
    });
</script>
@endsection
