<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MemberQuiz
 * 
 * @property int $id
 * @property int $member_id
 * @property int $quiz_id
 * @property string|null $reflection
 * @property string|null $open_answer
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Member $member
 * @property Quiz $quiz
 * @property Collection|MemberQuestion[] $member_questions
 *
 * @package App\Models
 */
class MemberQuiz extends Model
{
	protected $table = 'member_quizzes';

	protected $casts = [
		'member_id' => 'int',
		'quiz_id' => 'int'
	];

	protected $fillable = [
		'member_id',
		'quiz_id',
		'reflection',
		'open_answer'
	];

	public function member()
	{
		return $this->belongsTo(Member::class);
	}

	public function quiz()
	{
		return $this->belongsTo(Quiz::class);
	}

	public function member_questions()
	{
		return $this->hasMany(MemberQuestion::class);
	}
}
