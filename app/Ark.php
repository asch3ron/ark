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
	private $client;

	CONST NO_CONNECTED = 'Connection failed.';

	public function __construct()
	{
		$this->ip 		= '62.210.97.105';
		$this->port 	= 32330;
		$this->password = 'bbbbb';

		$this->connect();
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
            throw new \Exception(self::NO_CONNECTED, 1);
        }
	}

	public function getPlayers()
	{
		$this->action('listplayers');
	}

	private function action( $command )
	{
		if (false === $this->is_connected)
            throw new \Exception(self::NO_CONNECTED, 1);

		$response = $this->client->send( $command );
        return $response; // a,b,c
	}
}
