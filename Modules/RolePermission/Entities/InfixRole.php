<?php

namespace Modules\RolePermission\Entities;
use Illuminate\Database\Eloquent\Model;

class InfixRole extends Model
{
    protected $fillable = [];
    protected $casts = [
        'saas_schools' => 'array',
        'id' => 'integer',
        'name' => 'string',
    ];  
    public function assignedPermission()
    {
        return $this->hasMany(AssignPermission::class, 'role_id', 'id')->where('school_id', auth()->user()->school_id);
    }
    
    public function getNameAttribute($value)
    {
        // Map of role names to their display values
        $roleMap = [
            'super_admin' => 'Super Admin',
            'student' => 'Student',
            'parents' => 'Parents',
            'teacher' => 'Lecturer',
            'admin' => 'Admin',
            'accountant' => 'Accountant',
            'receptionist' => 'Receptionist',
            'librarian' => 'Librarian',
            'driver' => 'Driver'
        ];
        
        // Convert to lowercase and replace spaces with underscores for consistency
        $key = strtolower(str_replace(' ', '_', $value));
        
        // Return the mapped value or the original if not found
        return $roleMap[$key] ?? $value;
    }
}
