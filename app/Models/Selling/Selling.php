<?php

namespace App\Models\Selling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selling extends Model
{
    use HasFactory;
    protected $table = "selling";
    protected $fillable = [
        'code',
        'title',
        'date_input',
        'due_date',
        'rate',
        'subtotal',
        'discount',
        'pay',
        'customer_id',
        'bank_id',
        'note',
        'user_id',
    ];

    public function customers()
    {
        return $this->belongsTo('App\Models\Selling\Customer', 'customer_id');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function banks()
    {
        return $this->belongsTo('App\Models\Accounting\Bank', 'bank_id');
    }

    public function selling_details()
    {
        return $this->hasMany('App\Models\Selling\SellingDetail', 'selling_id', 'id');
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
