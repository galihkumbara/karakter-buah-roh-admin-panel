<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $proof_of_payment_url
 * @property int|null $user_id
 * @property int|null $member_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Member|null $member
 * @property User|null $user
 * @property Collection|Module[] $modules
 *
 * @package App\Models
 */
class Transaction extends Model
{
	protected $table = 'transactions';

	protected $casts = [
		'user_id' => 'int',
		'member_id' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'proof_of_payment_url',
		'user_id',
		'member_id'
	];

	public function member()
	{
		return $this->belongsTo(Member::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function modules()
	{
		return $this->belongsToMany(Module::class, 'transaction_modules')
					->withPivot('id', 'price')
					->withTimestamps();
	}

	public function transaction_modules()
	{
		return $this->hasMany(TransactionModule::class);
	}
}
