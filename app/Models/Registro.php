<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Registro
 * 
 * @property int $id
 * @property string $placa
 * @property int $vehiculo_id
 * @property Carbon $entrada
 * @property Carbon|null $salida
 * @property string $pagado
 * @property string|null $servicios_solicitados
 * 
 * @property Vehiculo $vehiculo
 *
 * @package App\Models
 */
class Registro extends Model
{
	protected $table = 'registros';
	public $timestamps = false;

	protected $casts = [
		'vehiculo_id' => 'int',
		'entrada' => 'datetime',
		'salida' => 'datetime'
	];

	protected $fillable = [
		'placa',
		'vehiculo_id',
		'entrada',
		'salida',
		'pagado',
		'servicios_solicitados'
	];

	public function vehiculo()
	{
		return $this->belongsTo(Vehiculo::class);
	}
}
