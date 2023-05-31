<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Factura
 * 
 * @property int $id
 * @property string $tipo_documento
 * @property string $tipo_resolucion
 * @property string $numero_resolucion
 * @property Carbon $fecha_autorizacion
 * @property int $numero_factura_inicial
 * @property int $numero_factura_actual
 * @property int $numero_factura_final
 * @property Carbon $fecha_inicio
 * @property Carbon $fecha_vencimiento
 * @property string $prefijo_facturacion
 * @property bool $activa
 *
 * @package App\Models
 */
class Factura extends Model
{
	protected $table = 'facturas';
	public $timestamps = false;

	protected $casts = [
		'fecha_autorizacion' => 'datetime',
		'numero_factura_inicial' => 'int',
		'numero_factura_actual' => 'int',
		'numero_factura_final' => 'int',
		'fecha_inicio' => 'datetime',
		'fecha_vencimiento' => 'datetime',
		'activa' => 'bool'
	];

	protected $fillable = [
		'tipo_documento',
		'tipo_resolucion',
		'numero_resolucion',
		'fecha_autorizacion',
		'numero_factura_inicial',
		'numero_factura_actual',
		'numero_factura_final',
		'fecha_inicio',
		'fecha_vencimiento',
		'prefijo_facturacion',
		'activa'
	];
}
