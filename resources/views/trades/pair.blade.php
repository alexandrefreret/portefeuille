@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Position</th>
					</tr>
				</thead>
				<tbody>
					@foreach($pairs as $pair)
					<tr>
						<td>{{ $pair->pair_name }}</td>
						<td>{{ $pair->pair_position }}</td>
						<td><a href="{{ route('trades/detail', ['id' => $pair->pair_id]) }}" class="btn btn-secondary">Voir les trades</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
        </div>
    </div>
</div>
@endsection
