<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Servicio
 * 
 * @property int $id
 * @property int $empresa_id
 * @property string $nombre
 * @property float $precio
 * 
 * @property Empresa $empresa
 *
 * @package App\Models
 */
class Servicio extends Model
{
	protected $table = 'servicios';
	public $timestamps = false;

	protected $casts = [
		'empresa_id' => 'int',
		'precio' => 'float'
	];

	protected $fillable = [
		'empresa_id',
		'nombre',
		'precio'
	];

	public function empresa()
	{
		return $this->belongsTo(Empresa::class);
	}
}
