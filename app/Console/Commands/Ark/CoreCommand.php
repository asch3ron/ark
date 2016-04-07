<?php

namespace Ark\Console\Commands\Ark;
use Illuminate\Console\Command;

class CoreCommand extends Command
{
    protected $_server;
    protected $game_server;

    public function __construct()
    {
        parent::__construct();

        $id_server      = 1;
        $this->_server  = \Ark\Models\Server::find( $id_server );
    }

    protected function retrieveServer()
    {
        try
        {
            $this->game_server = new \Ark\Ark();
            $this->game_server->setLogger( $this );
        }
        catch (\Exception $e)
        {

        }
    }

    public function getServer()
    {
        return $this->_server;
    }

    public function getGameServer()
    {
        return $this->game_server;
    }
}
