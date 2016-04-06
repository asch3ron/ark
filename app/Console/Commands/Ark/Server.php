<?php

namespace Ark\Console\Commands\Ark;

use Illuminate\Console\Command;

class Server extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ark:server {state}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $state = $this->argument('state');
        $this->server = new \Ark\Ark();

        if (true === method_exists($this, $state))
        {
            $this->{ $state }();
        }
        else
        {
            $this->error('Action `' . $state . '` not defined.');
        }
    }

    private function isServerUp()
    {
    }

    private function start()
    {
        $params = [
            '-gameplaylogging',
            '-server',
            '-log',
            '-servergamelog',
            '-usecache'
        ];

        $configurations = \Ark\Models\Configuration::all();

        $configurations = array_map(function($item){
            return $item['name'] . '=' . $item['default'];
        }, $configurations->toArray());

        $launch_command = './ShooterGameServer ' . env('ARK_MAP') . '?listen'
                        . implode('?', $configurations) . implode(' ', $params);

        $commands = [
            'cd ' . env('ARK_PATH') . '/ShooterGame/Binaries/Linux/',
            'ulimit -n 100000',
            $launch_command
        ];

        dd($commands);
        /*
            #!/bin/bash
            cd /home/steam/servers/ark/ShooterGame/Binaries/Linux/
            ulimit -n 100000
            ./ShooterGameServer TheIsland?listen?Message="coucou les aventuriers!"?SessionName="Les survivants de l'arche"?alwaysNotifyPlayerJoined=true?alwaysNotifyPlayerLeft=true?ShowMapPlayerLocation=true?MaxPlayers=6?proximityChat=false?ServerPassword=aaaaa?ServerAdminPassword=bbbbb -server -log -servergamelog
         */
    }

    private function stop()
    {

    }

    private function update()
    {
        // check if launch
        // so stop and restart after

        $commands = [
            'cd steamcmd/',
            './steamcmd.sh +login anonymous +force_install_dir ' . env('ARK_PATH') . ' +app_update "376030 validate" +quit'
        ];
    }

    private function status()
    {

    }
}
