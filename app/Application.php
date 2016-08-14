<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'zone',
        'forward_proxy_host',
        'enabled_https',
    ];
}
