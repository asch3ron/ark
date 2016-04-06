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
    public function __construct( $action )
    {
        $this->action = $action;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo '>> ' . $this->action . PHP_EOL;

        $output = shell_exec('php artisan ark:server ' . $this->action);

        echo $output . PHP_EOL;
    }
}
