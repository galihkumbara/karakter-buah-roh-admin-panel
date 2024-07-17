<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Regency
 * 
 * @property string $id
 * @property string $province_id
 * @property string $name
 *
 * @package App\Models
 */
class Regency extends Model
{
	protected $table = 'regencies';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'id',
		'province_id',
		'name'
	];
}
