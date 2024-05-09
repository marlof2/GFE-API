<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Status extends Model
{
    protected $guarded = ['id'];
    protected $fillable = ["name"];
}
