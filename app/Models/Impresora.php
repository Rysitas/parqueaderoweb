<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Impresora
 * 
 * @property int $id
 * @property string $nombre
 * @property int $tamaño
 * @property bool|null $activo
 *
 * @package App\Models
 */
class Impresora extends Model
{
	protected $table = 'impresora';
	public $timestamps = false;

	protected $casts = [
		'tamaño' => 'int',
		'activo' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'tamaño',
		'activo'
	];
}
