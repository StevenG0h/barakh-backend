<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpendingTransaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function unitUsaha(){
        return $this->belongsTo(UnitUsaha::class);
    }
}
