@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-auto user-image">
    	   <img src="/{{ $image->image ?? 'images/users/default_no_user.png' }}" alt="user image">
        </div>

        <div class="col-sm user-details-all">         
        	<div class="row user-details">
                <h5>Name:  {{ $user->name }} </h5>
            </div>

            <div class="row user-details">
                <h5>Date of birth:  {{ date('d-m-Y', strtotime($user->date_of_birth)) }} </h5>
            </div>

            <div class="row user-details">
                <h5>Address:  {{ $user->address }}</h5>
            </div>

            <div class="row user-details">
                <h5>E-mail:  {{ $user->email }}</h5>
            </div>

            <div class="row user-details">
                <h5>Telephone:  {{ $user->phone }} </h5>
            </div>
            
    		<div class="row user-details">
    			<a class="btn btn-primary button is-link button-edit" href = "/users/{{ $user->id }}/edit"> Edit details</a>	
    		</div>
    	</div>	
    </div>
</div>
	
@endsection