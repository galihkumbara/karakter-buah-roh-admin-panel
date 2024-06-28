<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MemberModule
 * 
 * @property int $id
 * @property int $member_id
 * @property int $module_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Member $member
 * @property Module $module
 *
 * @package App\Models
 */
class MemberModule extends Model
{
	protected $table = 'member_modules';

	protected $casts = [
		'member_id' => 'int',
		'module_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'member_id',
		'module_id',
		'is_active'
	];

	public function member()
	{
		return $this->belongsTo(Member::class);
	}

	public function module()
	{
		return $this->belongsTo(Module::class);
	}
}
