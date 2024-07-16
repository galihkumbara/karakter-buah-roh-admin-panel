<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Content
 * 
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $writer
 * @property bool $is_active
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property bool $always_show
 * @property string|null $media_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Content extends Model
{
	protected $table = 'contents';

	protected $casts = [
		'is_active' => 'bool',
		'start_date' => 'datetime',
		'end_date' => 'datetime',
		'always_show' => 'bool'
	];

	protected $fillable = [
		'title',
		'content',
		'writer',
		'is_active',
		'start_date',
		'end_date',
		'always_show',
		'media_url'
	];
}
