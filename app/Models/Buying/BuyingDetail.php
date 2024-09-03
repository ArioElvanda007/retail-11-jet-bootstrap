<?php

namespace App\Models\Buying;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyingDetail extends Model
{
    use HasFactory;
    protected $table = "buying_details";
    protected $fillable = [
        'buying_id',
        'prod_id',
        'rate',
        'amount',
        'discount',
    ];

    public function products()
    {
        return $this->belongsTo('App\Models\Stock\Product', 'prod_id');
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
