<?php

namespace Drewlabs\Changelog\Eloquent;

use Drewlabs\Changelog\LogDriver as AbstractLogDriver;

class LogDriver implements AbstractLogDriver
{
    /**
     * Creates log driver instances
     */
    public function __construct()
    {
    }

    public function logChange(string $table, string $instance, string $property, $previous, $actual, ?string $logBy = null)
    {
        /**
         * @var LogTable
         */
        $logTable = LogTable::query()->where('name', "$table")->first();
        if (is_null($logTable)) {
            /**
             * @var LogTable
             */
            $logTable = LogTable::create(['name' => $table]);
        }

        // We enclose implementation that retrieve authenticated user
        // id in a try...catch block in case the call throws an exception
        try {
            $logBy = \Illuminate\Support\Facades\Auth::id(); // TODO: Find out if it's possible to use auth user email
        } catch (\Throwable $e) {
            $logBy = null;
        }

        // Insert attrbutes change into log table attributes table
        LogTableAttribute::create([
            'table_id' => $logTable->getKey(),
            'instance_id' => $instance,
            'property' => $property,
            'previous_value' => $previous,
            'current_value' => $actual,
            'log_by' => $logBy,
            'log_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
