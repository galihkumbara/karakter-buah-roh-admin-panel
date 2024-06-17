<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ethnic
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
class Ethnic extends Model
{
	protected $table = 'ethnics';

	protected $fillable = [
		'name'
	];

	public function members()
	{
		return $this->hasMany(Member::class);
	}
}
