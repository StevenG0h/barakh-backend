<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function productImages(){
        return $this->hasMany(ProductImg::class);
    }
    
    public function unitUsaha(){
        return $this->belongsTo(UnitUsaha::class);
    }

    public function rating(){
        return $this->belongsTo(Rating::class);
    }
}
