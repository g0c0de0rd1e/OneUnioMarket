<?php

namespace Modules\Setup\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OneClickorderReceiveStatus extends Model
{
    use HasFactory;

    protected $fillable = ['status','id'];


}
