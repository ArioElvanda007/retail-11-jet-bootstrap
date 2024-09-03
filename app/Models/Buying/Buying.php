<?php

namespace App\Models\Buying;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buying extends Model
{
    use HasFactory;
    protected $table = "buying";
    protected $fillable = [
        'code',
        'title',
        'date_input',
        'due_date',
        'rate',
        'subtotal',
        'discount',
        'pay',
        'supplier_id',
        'bank_id',
        'note',
        'user_id',
    ];

    public function suppliers()
    {
        return $this->belongsTo('App\Models\Buying\Supplier', 'supplier_id');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function banks()
    {
        return $this->belongsTo('App\Models\Accounting\Bank', 'bank_id');
    }

    public function buying_details()
    {
        return $this->hasMany('App\Models\Buying\BuyingDetail', 'buying_id', 'id');
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
