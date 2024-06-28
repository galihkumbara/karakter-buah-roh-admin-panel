<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Member
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $profile_picture_url
 * @property Carbon|null $birthdate
 * @property string|null $address
 * @property int|null $institution_id
 * @property int|null $education_id
 * @property int|null $religion_id
 * @property int|null $ethnic_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Education|null $education
 * @property Ethnic|null $ethnic
 * @property Institution|null $institution
 * @property Religion|null $religion
 * @property Collection|Transaction[] $transactions
 *
 * @package App\Models
 */
class Member extends Model
{
	protected $table = 'members';

	protected $casts = [
		'birthdate' => 'datetime',
		'institution_id' => 'int',
		'education_id' => 'int',
		'religion_id' => 'int',
		'ethnic_id' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'email',
		'password',
		'profile_picture_url',
		'birthdate',
		'address',
		'institution_id',
		'education_id',
		'religion_id',
		'ethnic_id'
	];

	public function education()
	{
		return $this->belongsTo(Education::class);
	}

	public function modules()
	{
		return $this->belongsToMany(Module::class, 'member_modules')
					->withPivot('is_active')
					->withTimestamps();
	}

	public function ethnic()
	{
		return $this->belongsTo(Ethnic::class);
	}

	public function institution()
	{
		return $this->belongsTo(Institution::class);
	}

	public function religion()
	{
		return $this->belongsTo(Religion::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}

	public function member_questions()
	{
		return $this->hasMany(MemberQuestion::class);
	}

	public function questions()
	{
		return $this->belongsToMany(Question::class, 'member_questions')
					->withPivot('answer')
					->withTimestamps();
	}
}
