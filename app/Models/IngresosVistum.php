<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IngresosVistum
 * 
 * @property int $id
 * @property string $placa
 * @property Carbon $entrada
 * @property string $tipo
 * @property string $pagado
 *
 * @package App\Models
 */
class IngresosVistum extends Model
{
	protected $table = 'ingresos_vista';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'entrada' => 'datetime'
	];

	protected $fillable = [
		'id',
		'placa',
		'entrada',
		'tipo',
		'pagado'
	];
}
