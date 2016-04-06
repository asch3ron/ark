<?php

namespace Ark\Models\Server;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table = 'ark_server_configuration';

    protected $fillable = ['id_server', 'id_configuration', 'value'];
}
