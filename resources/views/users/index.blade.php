@extends('layouts.app')

@section('content')

<div class="row users-title">
    <div class="col-10"><h2>Users</h2></div>
    <div class="col-2"><button onclick="location.href='/users/create'" class="btn btn-primary add-user-button text-nowrap">Add user</button></div>
</div>
	
<table id="users-table" class="display">
	<thead>
   		<tr>
   			<th>Name</th>
   			<th>Address</th>
  			<th>Date of birth</th>
   		</tr>
	</thead>
	<tbody>
	@foreach($users as $user)				
	<tr onclick="location.href='/users/{{ $user->id }}'">
	   <td> {{ $user->name }} </td>
	   <td> {{ $user->address }} </td>
	   <td> {{ date('d-m-Y', strtotime($user->date_of_birth)) }} </td>
	</tr>
	@endforeach
	</tbody>	
</table>

<script>
	$(document).ready(function() {
		$('#users-table').DataTable();
	});
</script>

@endsection