<?php

namespace Ark\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $table = 'ark_server';
    protected $primaryKey = 'id_server';

    protected $fillable = ['name', 'ip', 'path', 'port'];

    public function setState( $state )
    {
    	$this->state = $state;

    	$this->save();

    	$this->addLog('Server change state : ' . $state);
    }

    public function addLog( $message )
    {
    	\Ark\Models\Server\Log::firstOrCreate([
            'id_server' => $this->id_server,
            'message'  	=> $message
        ]);
    }
}
