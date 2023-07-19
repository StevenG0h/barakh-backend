<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UnitUsaha extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function products():HasMany {
        return $this->hasMany(Product::class)->orderBy('updated_at','desc');
    }

    public function profil():HasOne{
        return $this->hasOne(ProfilUsaha::class);
    }
}
