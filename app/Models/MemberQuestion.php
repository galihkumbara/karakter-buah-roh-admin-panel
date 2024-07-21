<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MemberQuestion
 * 
 * @property int $id
 * @property int $member_id
 * @property int $question_id
 * @property string|null $answer
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Member $member
 * @property Question $question
 *
 * @package App\Models
 */
class MemberQuestion extends Model
{
	protected $table = 'member_questions';

	protected $casts = [
		'member_id' => 'int',
		'question_id' => 'int'
	];

	protected $fillable = [
		'member_id',
		'question_id',
		'answer',
		'member_quiz_id'
	];

	public function member()
	{
		return $this->belongsTo(Member::class);
	}

	public function question()
	{
		return $this->belongsTo(Question::class);
	}
}
