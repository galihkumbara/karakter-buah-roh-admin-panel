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
 * @property string $min_word
 * @property string $max_word
 * @property string $min_scale
 * @property string $max_scale
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
		'min_word',
		'max_word',
		'min_scale',
		'max_scale'
	];

	public function questionnaire()
	{
		return $this->belongsTo(Questionnaire::class);
	}
}
