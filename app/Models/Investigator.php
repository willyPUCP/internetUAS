<?php

namespace Intranet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investigator extends Model
{
    use SoftDeletes;

    public function faculty(){
        return $this->belongsTo('Intranet\Models\Faculty', 'id_especialidad');
    }

    public function area(){
        return $this->belongsTo('Intranet\Models\Area', 'id_area');
    }

    public function user(){
        return $this->belongsTo('Intranet\Models\User', 'id_usuario');
    }

    public function groups(){
    	return $this->belongsToMany('Intranet\Models\Group','investigatorxgroups','id_investigador','id_grupo')->withPivot('id');	
    }

    public function projects(){
        return $this->belongsToMany('Intranet\Models\Project','investigatorxprojects','id_investigador','id_proyecto')->withPivot('id');   
    }
}
