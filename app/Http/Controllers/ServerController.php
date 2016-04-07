<?php

namespace Ark\Http\Controllers;

use Ark\Http\Controllers\Controller;
use DB;
use Ark\Jobs\Server;
use Illuminate\Foundation\Bus\DispatchesJobs;
use gries\Rcon\MessengerFactory;
use gries\Rcon\Messenger;

class ServerController extends Controller {
    use DispatchesJobs;

    public function all()
    {
        return view('server', ['servers' => []]);
    }

    public function restart()
    {
        $this->dispatch(new Server('stop'));
        $this->dispatch(new Server('start'));
    }

    public function status()
    {
        $server     = new \Ark\Ark();
        $db_server  = \Ark\Models\Server::find( 1 );

        $info = [
            'name'              => $db_server->name,
            'ip'                => $db_server->ip,
            'port'              => $db_server->port,
            'state'             => $db_server->state,
        ];

        if (false === $server->isConnected())
            return $info;

        $configurations     = [];
        $configs            = DB::table('ark_configurations')
            ->leftJoin('ark_server_configuration', 'ark_server_configuration.id_configuration', '=', 'ark_configurations.id')
            ->select('ark_configurations.*', 'ark_server_configuration.value')
            ->where('ark_server_configuration.id_server', '=', $db_server->id_server)
            ->get();

        foreach ($configs as $config)
        {
            $configurations[ $config->name ] = $config->value;
        }

        $players        = $server->getPlayers();

        $info += [
            'nb_players'        => ('No Players Connected' === $players ? 0 : (int) $players),
            'max_players'       => (int) $configurations['MaxPlayers'],
        ];

        return $info;
        // try
        // {
        //     // setup the messenger
        //     $messenger = MessengerFactory::create('62.210.97.105', 32330, 'bbbbb');

        //     // send a simple message
        //     $response = $messenger->send('listplayers');
        //     return $response; // a,b,c
        // }
        // catch (\Exception $e)
        // {
        //     return $e->getMessage();
        // }
    }

    public function start()
    {
        $this->dispatch(new Server('start'));
    }

    public function stop()
    {
        $this->dispatch(new Server('stop'));
    }

    public function update()
    {
        $this->dispatch(new Server('update'));
    }

}
