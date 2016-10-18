<?php

namespace App\Console\Commands;

use App\Libraries\Elasticsearch\Installer;
use Illuminate\Console\Command;

class InstallElasticsearchCommand extends Command
{
    use Installer;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:elasticsearch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs Elasticsearch Database';

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
     * @return mixed
     */
    public function handle()
    {
        $this->runInstaller();
        //
    }
}
