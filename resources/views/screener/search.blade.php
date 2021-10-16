@extends('layouts.app')

@section('content')
<div class="container">
	<form action="{{ route('screener/search') }}" method="POST">
		@csrf()
		<div class="row justify-content-center">
			<div class="col">
				<div class="form-group">
					<label for="units">Unité de temps</label>
					<select name="units" id="units" class="form-control">
						@foreach ($units as $key => $value)
						<option value="{{ $key }}">{{ $key }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label for="moyenne_1">Moyenne mobile 1 (plus petite)</label>
					<input type="text" name="moyenne_1" id="moyenne_1" value="20" class="form-control">
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label for="moyenne_2">Moyenne mobile 2 (plus grande)</label>
					<input type="text" name="moyenne_2" id="moyenne_2" value="50" class="form-control">
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label for="pourcentage">Pourcentage</label>
					<input type="text" name="pourcentage" id="pourcentage" value="2" class="form-control">
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label for="moyenne_2">&nbsp;</label>
					<button class="btn btn-primary btn-block">Rechercher</button>
				</div>
			</div>
		</div>
	</form>
	
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Crypto</th>
				<th>Pourcentage</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($symbols as $item)
				<tr>
					<td>{{ $item["symbol"] }}</td>
					<td>{{ $item["pourcentage"] }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
