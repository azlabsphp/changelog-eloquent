<?php

namespace Drewlabs\Changelog\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class LogTableAttribute extends Model
{
	use HasUuids;

	/**
	 * Model referenced table
	 * 
	 * @var string
	 */
	protected $table = 'logs_table_properties';

	/**
	 * List of values that must be hidden when generating the json output
	 * 
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * List of attributes that will be appended to the json output of the model
	 * 
	 * @var array
	 */
	protected $appends = [];

	/**
	 * List of fillable properties of the current model
	 * 
	 * @var array
	 */
	protected $fillable = [
		'id',
        'table_id',
		'instance_id',
        'property',
        'previous_value',
        'current_value',
        'log_by',
        'log_at',
        'notes',
		'created_at',
		'updated_at',
	];

	/**
	 * Table primary key
	 * 
	 * @var string
	 */
	protected $primaryKey = 'id';
}