<?php

namespace App;

use App\Scopes\ActiveStatusSchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SmDormitoryList extends Model
{
    use HasFactory;

    protected $table = 'sm_accommodation_lists';

    protected $casts = [
        'id' => 'integer',
        'dormitory_name' => 'string',
    ];
    
    protected $fillable = [
        'dormitory_name',
        'type',
        'intake',
        'address',
        'description',
        'school_id',
        'academic_id',
        'active_status'
    ];
    
    public function rooms()
    {
        return $this->hasMany('App\SmRoomList', 'accommodation_id');
    }

    
    protected static function boot()
    {
        parent::boot();
  
        static::addGlobalScope(new ActiveStatusSchoolScope);
    } 
    
}
