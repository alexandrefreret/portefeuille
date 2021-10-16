<form action="{{ route('trades/add') }}" method="POST">
	@csrf
	<input type="hidden" name="pair_id" value="{{ $pair }}">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Prix achat</th>
				<th>Quantité $</th>
				<th>Sens</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type="text" name="price" class="form-control"></td>
				<td><input type="text" name="qte" class="form-control"></td>
				<td>
					<select name="direction" id="direction" class="form-control">
						<option value="1">Achat</option>
						<option value="0">Vente</option>
					</select>
				</td>
				<td>
					<button class="btn btn-primary">Ajouter</button>
				</td>
			</tr>
		</tbody>
	</table>
</form>