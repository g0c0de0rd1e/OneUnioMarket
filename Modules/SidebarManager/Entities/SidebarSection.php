<?php

namespace Modules\SidebarManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SidebarSection extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function menus(){
        return $this->hasMany(Sidebar::class, 'section_id', 'id')->where('parent_id', null)->orderBy('position');
    }
    
}
