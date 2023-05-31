<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Empresa
 * 
 * @property int $id
 * @property string $nombre
 * @property string $nit
 * @property string|null $descripcion
 * @property string|null $horario_atencion
 * @property string|null $gerente
 * @property string|null $ciudad
 * @property string|null $direccion
 * @property string $iva
 * @property string|null $logo
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Servicio[] $servicios
 *
 * @package App\Models
 */
class Empresa extends Model
{
	protected $table = 'empresas';

	protected $fillable = [
		'nombre',
		'nit',
		'descripcion',
		'horario_atencion',
		'gerente',
		'ciudad',
		'direccion',
		'iva',
		'logo'
	];

	public function servicios()
	{
		return $this->hasMany(Servicio::class);
	}
}
