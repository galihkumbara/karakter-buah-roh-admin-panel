<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Province
 * 
 * @property string $id
 * @property string $name
 *
 * @package App\Models
 */
class Province extends Model
{
	protected $table = 'provinces';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'id',
		'name'
	];
}
