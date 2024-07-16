<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionnaireQuestionMember
 * 
 * @property int $id
 * @property int $question_id
 * @property int $member_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Member $member
 * @property Question $question
 *
 * @package App\Models
 */
class QuestionnaireQuestionMember extends Model
{
	protected $table = 'questionnaire_question_members';

	protected $casts = [
		'question_id' => 'int',
		'member_id' => 'int'
	];

	protected $fillable = [
		'question_id',
		'member_id',
		'answer'
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
