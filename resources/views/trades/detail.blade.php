@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <table class="table table-bordered table-striped">
				<thead>
					<tr>
						<td>Quantité</td>
						<td>Montant</td>
						<td>PRU</td>
						<td>Sens</td>
						<td>Actions</td>
					</tr>
				</thead>
				<tbody>
					@foreach($trades as $key => $trade)
					<tr>
						<td>{{ $trade->trades_qte }}</td>
						<td>{{ $trade->trades_amount }}</td>
						<td>{{ $trade->trades_pru }}</td>
						<td>
							@if($trade->trades_direction == 1)
							<span class="text-success">Achat</span>
							@else
							<span class="text-danger">Vente</span>
							@endif
						</td>
						<td>
							@if((count($trades) - 1) == $key )
							<a href="{{ route('trades/delete', ['id' => $trade->trades_id]) }}" class="btn btn-danger" >Supprimer</a>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
        </div>
    </div>
	<div class="row justify-content-center">
        <div class="col">
			<x-trades.add pair="{{$pair->pair_id}}"/>
		</div>
	</div>
</div>
@endsection
