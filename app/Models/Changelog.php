<?php

namespace Ark\Models;

use Illuminate\Database\Eloquent\Model;

class Changelog extends Model
{
    protected $table = 'ark_changelog';
    protected $primaryKey = 'id_changelog';

    protected $fillable = ['version', 'text', 'seen'];
}
