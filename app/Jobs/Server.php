<?php

namespace Ark\Jobs;

use Ark\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Server extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    private $action;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $action, $id_server )
    {
        $this->action       = $action;
        $this->id_server    = (int) $id_server;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo '>> ' . $this->action . PHP_EOL;
        echo '>> ID_SERVER: ' . $this->id_server . PHP_EOL;

        $output = shell_exec('php artisan ark:server ' . $this->action . ' ' . $this->id_server);

        echo $output . PHP_EOL;
    }
}
