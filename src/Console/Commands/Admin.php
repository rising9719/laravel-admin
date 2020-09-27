<?php

namespace Shibaji\Admin\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class Admin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:install {argv?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin Command for installation process';

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
        return User::search($this->argument('argv'))->get();
    }
}
