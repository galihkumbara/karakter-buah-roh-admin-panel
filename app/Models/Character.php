<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * Class Character
 * 
 * @property int $id
 * @property string $name
 * @property string|null $bible_verse
 * @property string|null $bible_verse_text
 * @property bool $is_active
 * @property int $order_number
 * @property int $module_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Module $module
 *
 * @package App\Models
 */
class Character extends Model implements  Sortable
{
	use SortableTrait;
	public $sortable = [
        'order_column_name' => 'order_number',
        'sort_when_creating' => true,
    ];
	protected $table = 'characters';

	protected $casts = [
		'is_active' => 'bool',
		'order_number' => 'int',
		'module_id' => 'int'
	];

	protected $fillable = [
		'name',
		'bible_verse',
		'bible_verse_text',
		'is_active',
		'order_number',
		'module_id'
	];

	protected $appends = ['path'];
	public function getPathAttribute()
	{
		return null;
	}
	public function module()
	{
		return $this->belongsTo(Module::class);
	}

	public function quizzes()
	{
		return $this->hasMany(Quiz::class);
	}



}
