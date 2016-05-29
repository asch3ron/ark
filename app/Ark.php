<?php

namespace Ark;

use gries\Rcon\MessengerFactory;
use gries\Rcon\Messenger;

class Ark
{
	private $ip;
	private $port;
	private $password;
	private $is_connected = false;
	private $client = null;
	private $logger = null;
	private $_server;

	CONST NO_CONNECTED = 'Connection failed.';

	public function __construct( $id_server )
	{
        $this->_server  = \Ark\Models\Server::find( $id_server );
        // get password

		$this->ip 		= $this->_server->ip;
		$this->port 	= $this->_server->port;
		$this->password = 'bbbbb';

		$this->connect();
	}

	public function setLogger( $logger )
	{
		$this->logger = $logger;
	}

	public function connect()
	{
		try
        {
            $this->client 		= MessengerFactory::create($this->ip, $this->port, $this->password);
            $this->is_connected = true;
        }
        catch (\Exception $e)
        {
            // throw new \Exception(self::NO_CONNECTED, 1);
        }
	}

	public function isConnected()
	{
		return $this->is_connected;
	}

	public function getPlayers()
	{
		return $this->action('listplayers');
	}

	public function ping()
	{
		$action = $this->action('ping');
		return ($action === 'Server received, But no response!!' || empty($action));
	}

	public function save()
	{
		return $this->action('admincheat saveworld');
	}

	public function shutdown()
	{
		$this->save();

		return $this->action('DoExit');
	}

	private function log( $message, $type = 'line' )
	{
		if (null !== $this->logger)
			$this->logger->{ $type }( $message );
	}

	private function action( $command )
	{
		$this->log('Action : ' . $command);
		if (false === $this->is_connected)
		{
			$this->log('/!\ KO', 'error');
            throw new \Exception(self::NO_CONNECTED, 1);
		}
		$this->log('>> OK', 'info');

		$response = $this->client->send( $command );
        return $response; // a,b,c
	}
}
