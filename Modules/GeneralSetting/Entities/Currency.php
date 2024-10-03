<?php

namespace Modules\GeneralSetting\Entities;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $guarded = [];
    protected $casts = ['status' => 'integer', 'convert_rate' => 'double'];
}
