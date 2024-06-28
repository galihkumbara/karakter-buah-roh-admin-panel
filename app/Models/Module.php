<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * Class Module
 * 
 * @property int $id
 * @property string $name
 * @property bool $is_active
 * @property string $color
 * @property int $order_number
 * @property int $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Character[] $characters
 * @property Collection|Quiz[] $quizzes
 * @property Collection|Transaction[] $transactions
 *
 * @package App\Models
 */
class Module extends Model implements Sortable
{
    use SortableTrait;
	protected $table = 'modules';
	public $sortable = [
        'order_column_name' => 'order_number',
        'sort_when_creating' => true,
    ];

	protected $casts = [
		'is_active' => 'bool',
		'order_number' => 'int',
		'price' => 'int'
	];

	protected $fillable = [
		'name',
		'is_active',
		'color',
		'order_number',
		'price'
	];

	public function characters()
	{
		return $this->hasMany(Character::class);
	}

	public function quizzes()
	{
		return $this->hasMany(Quiz::class);
	}

	public function transactions()
	{
		return $this->belongsToMany(Transaction::class, 'transaction_modules')
					->withPivot('id', 'price')
					->withTimestamps();
	}

	public function members()
	{
		return $this->belongsToMany(Member::class, 'member_modules')
					->withPivot('is_active')
					->withTimestamps();
	}

	public function member_modules()
	{
		return $this->hasMany(MemberModule::class);
	}

	public function transaction_modules()
	{
		return $this->hasMany(TransactionModule::class);
	}



}
