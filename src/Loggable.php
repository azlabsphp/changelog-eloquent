<?php

namespace Drewlabs\Changelog\Eloquent;

use Drewlabs\Changelog\Logger;
use Illuminate\Database\Eloquent\Model;
use Drewlabs\Changelog\Loggable as AbstractLoggable;
use Drewlabs\Core\Helpers\Arr;

/**
 * @mixin Model
 * @mixin AbstractLoggable
 */
trait Loggable
{

    /**
     * Provides mixin that when used on eloquent model will attempt to
     * log model changes to database
     * 
     * @return void 
     */
    public static function bootLoggable()
    {
        static::saved(function (self $model) {
            $changes = $model->getChanges();
            foreach (Arr::except($changes, ['updated_at', 'deleted_at', 'created_at']) as $key => $value) {
                Logger::getInstance()->logChange($model->getLogTableName(), $model->getKey(), $key, $model->getOriginal($key), $value);
            }
        });
    }
}
