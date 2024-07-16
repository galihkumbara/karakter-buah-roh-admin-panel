<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Questionnaire
 * 
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property bool $is_active
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|QuestionnaireQuestion[] $questionnaire_questions
 *
 * @package App\Models
 */
class Questionnaire extends Model
{
	protected $table = 'questionnaires';

	protected $casts = [
		'is_active' => 'bool',
		'start_date' => 'datetime',
		'end_date' => 'datetime'
	];

	protected $fillable = [
		'title',
		'description',
		'is_active',
		'start_date',
		'end_date'
	];

	public function questionnaire_questions()
	{
		return $this->hasMany(QuestionnaireQuestion::class);
	}
}
