<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class District
 * 
 * @property string $id
 * @property string $regency_id
 * @property string $name
 *
 * @package App\Models
 */
class District extends Model
{
	protected $table = 'districts';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'id',
		'regency_id',
		'name'
	];
}
