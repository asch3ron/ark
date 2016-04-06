<?php

namespace Ark\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table = 'ark_configurations';

    protected $fillable = ['name', 'type', 'default', 'comment'];

}
