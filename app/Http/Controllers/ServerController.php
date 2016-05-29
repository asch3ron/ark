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
        $all = \Ark\Models\Server::all();

        return view('server', ['servers' => $all]);
    }

    public function status( $id_server )
    {
        $server     = new \Ark\Ark( $id_server );
        $db_server  = \Ark\Models\Server::find( $id_server );

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
    }

    public function start( $id_server )
    {
        $this->dispatch(new Server('start', $id_server));
    }

    public function restart( $id_server )
    {
        $this->dispatch(new Server('stop', $id_server));
        $this->dispatch(new Server('start', $id_server));
    }

    public function stop( $id_server )
    {
        $this->dispatch(new Server('stop', $id_server));
    }

    public function update( $id_server )
    {
        $this->dispatch(new Server('update', $id_server));
    }

}
