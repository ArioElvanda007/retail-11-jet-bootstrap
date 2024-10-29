<?php

namespace App\Models\Selling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellingDetail extends Model
{
    use HasFactory;
    protected $table = "selling_details";
    protected $fillable = [
        'selling_id',
        'prod_id',
        'cogs',
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
