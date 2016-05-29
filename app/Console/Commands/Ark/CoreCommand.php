<?php

namespace Ark\Console\Commands\Ark;
use Illuminate\Console\Command;

class CoreCommand extends Command
{
    protected $_server;
    protected $_id_server;
    protected $game_server;

    public function __construct()
    {
        parent::__construct();


    }

    protected function retrieveServer()
    {
        try
        {
            $this->game_server = new \Ark\Ark( $this->getServer()->id_server );
            $this->game_server->setLogger( $this );
        }
        catch (\Exception $e)
        {

        }
    }

    public function setIDServer( $id_server )
    {
        $this->_id_server = $id_server;
    }

    public function getServer()
    {
        if (!$this->_server)
        {
            $id_server      = $this->_id_server;
            $this->_server  = \Ark\Models\Server::find( $id_server );

            if (null === $this->_server)
            {
                throw new \Exception('Server (' . $this->_id_server . ') not exist', 1);
            }
        }
        return $this->_server;
    }

    public function getGameServer()
    {
        return $this->game_server;
    }
}
