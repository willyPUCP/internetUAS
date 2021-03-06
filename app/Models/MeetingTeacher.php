<?php namespace Intranet\Models;

use Illuminate\Database\Eloquent\Model;
use Intranet\Models\Traits\LastUpdatedTrait;
use Illuminate\Database\Eloquent\SoftDeletes;


class MeetingTeacher extends Model
{
    use SoftDeletes;
    use LastUpdatedTrait;
    protected $table = 'pspmeetings';

    public function supervisor(){
        return $this->belongsTo('Intranet\Models\Supervisor', 'idsupervisor');
    }

    public function student(){
    	return $this->belongsTo('Intranet\Models\Student','idstudent');
    }
    
}
