<?php

namespace App;

use App\Scopes\ActiveStatusSchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmRoomList extends Model
{
    use HasFactory;
    
    protected $table = 'sm_accommodation_rooms';
    
    protected $fillable = [
        'name',
        'accommodation_id',
        'room_type_id',
        'number_of_bed',
        'cost_per_bed',
        'description',
        'school_id',
        'academic_id',
        'un_academic_id',
        'active_status'
    ];
    
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveStatusSchoolScope);
    }
   
    public function accommodation()
    {
        return $this->belongsTo('App\SmDormitoryList', 'accommodation_id');
    }
    
    // Keep this for backward compatibility
    public function dormitory()
    {
        return $this->belongsTo('App\SmDormitoryList', 'accommodation_id');
    }

    public function roomType()
    {
        return $this->belongsTo('App\SmRoomType', 'room_type_id');
    }
}
