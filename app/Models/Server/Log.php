<?php

namespace Ark\Models\Server;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'ark_server_log';

    protected $fillable = ['message', 'id_server'];

}
