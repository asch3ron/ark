<?php

namespace Ark\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $table = 'ark_server';

    protected $fillable = ['name', 'ip', 'path', 'port'];
}
