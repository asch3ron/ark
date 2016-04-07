<?php

namespace Ark\Console\Commands\Ark;

use Illuminate\Console\Command;

class Cron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ark:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install & configure all crontab';

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
        $path           = ARTISAN_PATH;
        $cron_path      = $this->ask('What is your cron.d/ark_server path ?', '/etc/cron.d/');
        $data           = '*/5  *   *   *   * root    /usr/bin/php ' . $path . '/artisan ark:ping' . PHP_EOL;
        $data          .= '*/30  *   *   *   * root    /usr/bin/php ' . $path . '/artisan ark:changelog' . PHP_EOL;

		file_put_contents($cron_path . '/ark_server', $data);

		$this->line('>> .env ark configuration rewrite!');
    }
}
