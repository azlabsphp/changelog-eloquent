<?php

namespace Drewlabs\Changelog\Eloquent\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

class Migrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'changelog:migrate {--connection=mysql : Database connection on which migration is executed} {--refresh : Reset database table migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate changelog database tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dbManager = new Manager($this->laravel);
        $dbManager->addConnection(config(sprintf("database.connections.%s", $this->option('connection'))));
        $dbManager->bootEloquent();
        $dbManager->setAsGlobal();

        if ($this->option('refresh')) {
            Manager::schema()->dropIfExists('logs_table_attributes');
            Manager::schema()->dropIfExists('logs_tables');
        }

        if (Manager::schema()->hasTable('logs_tables')) {
            $this->error('Migration error, table logs_tables exists in database');
            return Command::FAILURE;
        }

        if (Manager::schema()->hasTable('logs_table_attributes')) {
            $this->error('Migration error, table logs_table_attributes exists in database');
            return Command::FAILURE;
        }

        Manager::schema()->create('logs_tables', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 145)->index()->comment('Nom de la table impactée par les changements, de préférence utiliser une comibinaison non de base de données + nom table');
            $table->timestamps();
        });

        Manager::schema()->create('logs_table_properties', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('table_id');
            $table->string('instance_id', 45)->index();
            $table->string('property', 145)->index();
            $table->text('previous_value')->nullable();
            $table->text('current_value');
            $table->string('log_by', 145)->index();
            $table->dateTime('log_at')->nullable();
            $table->text('notes')->nullable();
            $table->foreign('table_id')->references('id')->on('logs_tables')->onDelete('cascade');
            $table->timestamps();
        });

        $this->info('Table migrated successfully!');
        
        return Command::SUCCESS;
    }

}