<!DOCTYPE html>
<html>
<head>
	<title>Recibo de Pago</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			font-size: 12px;
		}
		.container {
			text-align: left;
		}

		.header {
			text-align: center;
			font-weight: bold;
			line-height: 1.2;
		}

		table {
			border-collapse: collapse;
			margin-bottom: 1px;
			border-top: 1px solid black;
			border-bottom: 1px solid black;
			margin-top: 5px;
		}

		th, td {
			text-align: left;
			border-bottom: 1px solid black;
			font-weight: normal;
			padding: 3px 5px;
		}

		th {
			font-weight: bold;
		}

		.barcode {
			display: flex;
			justify-content: center;
			margin-bottom: 10px;
			text-align: center;
			margin-top: 10px;
			max-width: 80%;
			height: auto;
			line-height: 1.2;
		}

		.description {
			text-align: justify;
			font-size: 12px;
			line-height: 1.2;
			margin-top: 10px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<h2>Recibo de Pago</h2>
			<p style="font-weight: bold">{{ $nombreEmpresa }}</p>
			<p style="font-weight: bold">N.I.T {{ $nit }}</p>
			@if($prefijo_facturacion != NULL)
			<p style="font-weight: bold">{{ $tipo_documento }} {{$prefijo_facturacion}} {{ $numero_factura_actual }}</p>
			@else
			<p style="font-weight: bold">{{ $tipo_documento }} {{ $numero_factura_actual }}</p>
			@endif
            <hr style="margin-top: 5px; margin-bottom: 5px;">
			@if ($iva == 'No')
            	<p style="font-weight: bold; text-align: center;">EMPRESA NO RESPONSABLE DE IVA</p>
            @else
				<p style="font-weight: bold; text-align: center;">EMPRESA RESPONSABLE DE IVA</p>
            @endif
		</div>
		<table>
			<tr>
				<th style="width: 40%;">Placa del Vehículo:</th>
				<td style="width: 60%;">{{ $placa }}</td>
			</tr>
			<tr>
				<th style="width: 40%;">Tipo del Vehículo:</th>
				<td style="width: 60%;">{{ $tipoVehiculo }}</td>
			</tr>
			<tr>
				<th style="width: 40%;">Hora de entrada:</th>
				<td style="width: 60%;">{{ $hora_entrada }}</td>
			</tr>
			<tr>
				<th style="width: 40%;">Hora de salida:</th>
				<td style="width: 60%;">{{ $hora_salida }}</td>
			</tr>
			<tr>
				<th style="width: 40%;">Tiempo transcurrido:</th>
				<td style="width: 60%;">
					<table style="width: 100%; text-align: center;">
						<thead>
							<tr>
								<th style="width: 25%; font-weight: bold;">D</th>
								<th style="width: 25%; font-weight: bold;">H</th>
								<th style="width: 25%; font-weight: bold;">M</th>
								<th style="width: 25%; font-weight: bold;">S</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{{ $dias }}</td>
								<td>{{ $horas }}</td>
								<td>{{ $minutos }}</td>
								<td>{{ $segundos }}</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<th style="width: 40%;">Valor del servicio:</th>
				<td style="width: 60%;">${{ $valor_servicio_parqueadero }}</td>
			</tr>
			@if ($valor_servicio != 0)
			<tr>
				<th style="width: 40%;">Valor de otros servicios:</th>
				<td style="width: 60%;">${{ $valor_servicio }}</td>
			</tr>
			@endif
			@if ($iva != 'No')
			<tr>
				<th style="width: 40%;">I.V.A. 19%:</th>
				<td style="width: 60%;">${{ $valor_iva }}</td>
			</tr>
			@endif
			<tr>
				<th style="width: 40%;">Valor a pagar:</th>
				<td style="width: 60%;">${{ $valor_pagar }}</td>
			</tr>
		</table>
		<div>
			<p style="font-weight: bold; text-align: center;">Resolución de {{ $tipo_resolucion}}</p>
			<p style="font-weight: bold; text-align: center;">No. {{ $numero_resolucion}} del {{date('d/m/Y', strtotime($fecha_inicio))}} hasta {{date('d/m/Y', strtotime($fecha_vencimiento))}}</p>
			<p style="font-weight: bold; text-align: center;">Numeración desde {{$numero_factura_inicial}} hasta {{$numero_factura_final}}</p>	
		</div>
		<div class="description" style="font-weight: bold; text-align: center;">
			<p>{{ $descripcion }}</p>
		</div>
	</div>
</body>
</html>