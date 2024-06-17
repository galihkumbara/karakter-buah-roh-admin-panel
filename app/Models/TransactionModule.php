<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionModule
 * 
 * @property int $id
 * @property int $transaction_id
 * @property int $module_id
 * @property int $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Module $module
 * @property Transaction $transaction
 *
 * @package App\Models
 */
class TransactionModule extends Model
{
	protected $table = 'transaction_modules';

	protected $casts = [
		'transaction_id' => 'int',
		'module_id' => 'int',
		'price' => 'int'
	];

	protected $fillable = [
		'transaction_id',
		'module_id',
		'price'
	];

	public function module()
	{
		return $this->belongsTo(Module::class);
	}

	public function transaction()
	{
		return $this->belongsTo(Transaction::class);
	}
}
