<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    use HasFactory;
    protected $table = "access";
    protected $fillable = [
        'user_id',
        'role_id',
        'permission_id',
        'module_id',
        'can_view',
        'can_create',
        'can_update',
        'can_delete',
    ];

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    public function getUpdatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }   

    public function modules()
    {
        return $this->belongsTo('App\Models\Module', 'module_id');
    }
}
