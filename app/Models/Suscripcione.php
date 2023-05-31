<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Suscripcione
 * 
 * @property int $id
 * @property int $vehiculo_id
 * @property Carbon $inicio
 * @property Carbon $fin
 * 
 * @property Vehiculo $vehiculo
 *
 * @package App\Models
 */
class Suscripcione extends Model
{
	protected $table = 'suscripciones';
	public $timestamps = false;

	protected $casts = [
		'vehiculo_id' => 'int',
		'inicio' => 'datetime',
		'fin' => 'datetime'
	];

	protected $fillable = [
		'vehiculo_id',
		'inicio',
		'fin'
	];

	public function vehiculo()
	{
		return $this->belongsTo(Vehiculo::class);
	}
}
