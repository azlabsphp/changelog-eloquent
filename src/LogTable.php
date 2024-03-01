<?php

namespace Drewlabs\Changelog\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class LogTable extends Model
{
	/**
	 * Model referenced table
	 * 
	 * @var string
	 */
	protected $table = 'logs_tables';

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
        'name',
		'updated_at',
	];

	/**
	 * Table primary key
	 * 
	 * @var string
	 */
	protected $primaryKey = 'id';
}