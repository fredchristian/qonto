<?php

namespace Brocorp\Qonto\Console;

use Illuminate\Console\Command;

class QontoInstall extends Command
{
    protected $signature = 'qonto:install';
    protected $description = 'Install Qonto package';


    public function handle()
    {   
        $this->info('Installing Qonto package...');
        $this->line('');

        if ($this->confirm('Have you set your .ENV file with your Qonto credentials?')) {
            $this->line(' -> Publishing config/qonto.php');
            $this->call('vendor:publish', ['--provider' => "Brocorp\Qonto\QontoServiceProvider", '--tag' => "config" ]);
            $this->line('');

            $this->line(' -> Creating tables in your database');
            $this->call('migrate');
            $this->line('');

            $this->line(' -> Connecting to Qonto API');
            $this->call('qonto:init');
            $this->line('');

        } else {
            $this->error(' Installation aborted ');
            $this->line(' -> please setup first your .ENV file with your Qonto credentials');
            $this->line('');
        }
    }
}