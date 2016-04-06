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
        $server = new \Ark\Ark();

        $server->getPlayers();
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
