<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Professional extends Model
{
    protected $guarded = ['id'];
    protected $fillable = ["profile_id","name","cpf","email","phone","password","valid"];
}
