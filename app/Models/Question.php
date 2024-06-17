<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * 
 * @property int $id
 * @property string $question
 * @property int $quiz_id
 * @property int $order_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Quiz $quiz
 *
 * @package App\Models
 */
class Question extends Model
{
	protected $table = 'questions';

	protected $casts = [
		'quiz_id' => 'int',
		'order_number' => 'int'
	];

	protected $fillable = [
		'question',
		'quiz_id',
		'order_number'
	];

	public function quiz()
	{
		return $this->belongsTo(Quiz::class);
	}
}
