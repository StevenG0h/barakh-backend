<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilUsaha extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function unitUsaha(){
        return $this->belongsTo(UnitUsaha::class);
    }

    public function profilUsahaImages(){
        return $this->hasMany(ProfilUsahaImages::class)->orderBy('order','asc');
    }
}
