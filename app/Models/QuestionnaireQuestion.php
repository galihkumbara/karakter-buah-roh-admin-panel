<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionnaireQuestion
 * 
 * @property int $id
 * @property int $questionnaire_id
 * @property string $question
 * @property string $option_1
 * @property string $option_2
 * @property string $option_3
 * @property string $option_4
 * @property string $option_5
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Questionnaire $questionnaire
 *
 * @package App\Models
 */
class QuestionnaireQuestion extends Model
{
	protected $table = 'questionnaire_questions';

	protected $casts = [
		'questionnaire_id' => 'int'
	];

	protected $fillable = [
		'questionnaire_id',
		'question',
		'option_1',
		'option_2',
		'option_3',
		'option_4',
		'option_5'
	];

	public function questionnaire()
	{
		return $this->belongsTo(Questionnaire::class);
	}
}
