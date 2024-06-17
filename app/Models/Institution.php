<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Institution
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Member[] $members
 *
 * @package App\Models
 */
class Institution extends Model
{
	protected $table = 'institutions';

	protected $fillable = [
		'name'
	];

	public function members()
	{
		return $this->hasMany(Member::class);
	}
}
