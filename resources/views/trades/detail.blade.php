@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <table class="table table-bordered table-striped">
				<thead>
					<tr>
						<td>Quantité</td>
					</tr>
				</thead>
				<tbody>
					@foreach($trades as $trade)
					<tr>
						<td>{{ $trade->trades_qte }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
        </div>
    </div>
</div>
@endsection
