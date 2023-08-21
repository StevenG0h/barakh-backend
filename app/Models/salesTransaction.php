<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salesTransaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function kelurahan(){
        return $this->belongsTo(Kelurahan::class);
    }
    
    public function kecamatan(){
        return $this->belongsTo(Kecamatan::class);
    }
    
    public function kota(){
        return $this->belongsTo(Kota::class);
    }
    
    public function provinsi(){
        return $this->belongsTo(Provinsi::class);
    }
}
