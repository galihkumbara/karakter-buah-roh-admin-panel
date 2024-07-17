<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Village
 * 
 * @property string $id
 * @property string $district_id
 * @property string $name
 *
 * @package App\Models
 */
class Village extends Model
{
	protected $table = 'villages';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'id',
		'district_id',
		'name'
	];
}
