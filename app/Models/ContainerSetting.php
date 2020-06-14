<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContainerSetting extends Model
{
    protected $table = 'container_setting';
    public function getContainers()
	{
	    return $this->hasMany('App\Models\Container','container_setting_id');
	}
}