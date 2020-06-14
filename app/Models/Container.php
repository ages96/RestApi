<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    protected $table = 'containers';

    public function getSetting()
	{
	    return $this->hasOne('App\Models\ContainerSetting','id');
	}

}