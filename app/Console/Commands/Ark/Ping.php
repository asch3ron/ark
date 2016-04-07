<?php

namespace Ark\Console\Commands\Ark;

use Illuminate\Console\Command;

class Ping extends CoreCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ark:ping';

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
        $this->retrieveServer();

        try
        {
            $server_up = $this->getGameServer()->ping();
        }
        catch (\Exception $e)
        {
            $server_up = false;
        }

        $this->{ ($server_up ? 'info' : 'error') }('Server is ' . ($server_up ? 'UP' : 'DOWN'));

        switch ($this->getServer()->state)
        {
            case 'ko' : break;
            case 'launching' :
                if (true === $server_up)
                {
                    $this->getServer()->setState('ok');
                    $this->info('Server started successfully!');
                }
                else
                {
                    // check if time > 15 min set KO
                    // $this->error('Server failed to start :(');
                }
            break;
            default :
                if (false === $server_up)
                {
                    $this->error('Server crashed ? :/');
                    $this->getServer()->setState('ko');
                    // check if time > 15 min set KO
                }
            break;
        }
    }
}
