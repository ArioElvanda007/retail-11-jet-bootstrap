<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_Has_Module extends Model
{
    use HasFactory;
    protected $table = "permission_has_modules";
    protected $fillable = [
        'permission_id',
        'module_id',
    ];

    public function modules()
    {
        return $this->belongsTo('App\Models\Module', 'module_id');
    }

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    public function getUpdatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }       

}
