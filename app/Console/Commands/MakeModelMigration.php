<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeModelMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make_model_migration {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Model & Migration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = $this->argument('table');
        $migration = strtosnake( $model);
        Artisan::call('make:model '.$model);
        Artisan::call('make:migration '.$migration.' --create='.$migration);
    }
}
