@extends('layouts.app')

@section('content')

<div class="row books-title">
    <div class="col-10"><h2>Books</h2></div>
    <div class="col-2"><button onclick="location.href='/books/create'" class="btn btn-primary add-book-button text-nowrap">Add book</button></div>
</div>
@if($books->count())
<table id="books-table" class="display">
	<thead>
  		<tr>
   			<th>Title</th>
   			<th>Author</th>
   			<th>Copies</th>
   			<th>Available</th>
   		</tr>
	</thead>
	<tbody>
	@foreach($books as $book)
	<tr onclick="location.href='/books/{{ $book->id }}'">
		<td> {{ $book->title }} </td>
		<td> {{ $book->author }} </td>
		<td> {{ $book->copies }} </td>
		<td> {{ $book->available }} </td>				
	</tr>
	@endforeach
	</tbody>	
</table>
			
<script>
	$(document).ready(function() {
		$('#books-table').DataTable( {
			stateSave: true
		});
	});
</script>
@else
	<p>No books in database.</p>
@endif
@endsection