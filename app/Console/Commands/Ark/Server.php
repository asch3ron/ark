<?php

namespace Ark\Console\Commands\Ark;

use DB;

class Server extends CoreCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ark:server {state} {id_server}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $server = null;
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

        $this->setIDServer( $this->argument('id_server') );

        $this->retrieveServer();

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

        // $configurations = \Ark\Models\Server\Configuration::all();
        $configurations = DB::table('ark_configurations')
            ->leftJoin('ark_server_configuration', 'ark_server_configuration.id_configuration', '=', 'ark_configurations.id')
            ->select('ark_configurations.*', 'ark_server_configuration.value')
            ->where('ark_server_configuration.id_server', '=', $this->getServer()->id_server)
            ->get();

        $configurations = array_map(function($item){
            return $item->name . '=' . escapeshellcmd($item->value);
        }, $configurations);

        $launch_command = './ShooterGameServer ' . env('ARK_MAP') . '?listen'
                        . '?SessionName="' . $this->getServer()->name . '"?'
                        . implode('?', $configurations) . implode(' ', $params);

        $commands = [
            'ulimit -n 100000',
            'cd ' . $this->getServer()->path . '/ShooterGame/Binaries/Linux/',
            $launch_command . ' &'
        ];

        $this->getServer()->setState('launching');

        $result = $this->executeCommands( $commands );

        $this->line($result);
    }

    private function stop()
    {
        if (false === $this->getGameServer()->isConnected())
        {
            $this->warn('Server already stop');
        }
        else
        {
            $this->info('Stoping the server');

            $this->getServer()->addLog('Server saving and shutdown');
            $this->getGameServer()->shutdown();
        }
    }

    private function update()
    {
        // check if launch
        // so stop and restart after

        $commands = [
            'cd steamcmd/',
            './steamcmd.sh +login anonymous +force_install_dir ' . env('ARK_PATH') . ' +app_update "376030 validate" +quit'
        ];

        $this->getServer()->addLog('Server starting to update ... (it can take a while)');
        if (false === $this->getGameServer()->isConnected())
        {
            $this->line($this->executeCommands( $commands ));
        }
        else
        {
            $this->stop();
            $this->line($this->executeCommands( $commands ));
            $this->start();
        }
        $this->getServer()->addLog('Server finishing to update !');
    }

    private function status()
    {
        try
        {
            $this->getGameServer()->getPlayers();
        }
        catch (\Exception $e)
        {
            $this->line('Server is down.');
        }
    }

    private function executeCommands( $commands )
    {
        $command = implode(' && ', $commands);

        $this->info($command);
        $output = shell_exec( $command );

        return $output;
    }
}
