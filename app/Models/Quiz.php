<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Quiz
 * 
 * @property int $id
 * @property string $name
 * @property bool $is_active
 * @property int $order_number
 * @property int $module_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Module $module
 * @property Collection|Question[] $questions
 *
 * @package App\Models
 */
class Quiz extends Model
{
	protected $table = 'quizzes';

	protected $casts = [
		'is_active' => 'bool',
		'order_number' => 'int',
		'module_id' => 'int'
	];

	protected $fillable = [
		'name',
		'is_active',
		'order_number',
		'module_id'
	];

	public function character()
	{
		return $this->belongsTo(Character::class);
	}

	public function questions()
	{
		return $this->hasMany(Question::class);
	}
}
