<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class Kit extends Model
{
    use SoftDeletes, HasApiTokens, HasFactory;
    protected $guarded      = [];
}