@extends('layouts.app')

@section('content')

<div class="row owes-title">
    <div class="col-10"><h2>Current owes</h2></div>
</div>
@if($owes->count())
<table id="owes-table" class="display">
	<thead class="">
   		<tr>
  			<th scope="col">Book</th>
  			<th scope="col">Debtor</th>
  			<th scope="col">Rent date</th>
   			<th scope="col"></th>
   		</tr>
	</thead>
	<tbody>
	@foreach($owes as $owe)
	<tr>
		<td> {{ $owe->title }} </td>
		<td> {{ $owe->name }} </td>
		<div class="col owe-row-content {{ strtotime($owe->oweDate) < strtotime('-30 days') ? 'red' : '' }}">
			<td> {{ date('d-m-Y', strtotime($owe->oweDate)) }} </td>
		</div>
		<td>
			<form id="returnBook" method="POST" action="/owes/{{ $owe->oweId }}">
			@method('DELETE')
			@csrf
        	    <img alt="Return a book" src="images/book_return.png" onclick="document.getElementById('returnBook').submit();" data-toggle="tooltip" title="Return a book">
			</form>
		</td>
	</tr>
	@endforeach
	</tbody>	
</table>

<script>
	$(document).ready(function() {
		$('#owes-table').DataTable();
	});
</script>

@else
	<p>Owes records are empty.</p>
@endif
</div>

@endsection
