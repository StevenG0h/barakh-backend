<?php

namespace App\Models;

use App\Http\Traits\RelationTraits\AdminHasTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';

    protected $guarded= ['id'];

    public function role(){
        return $this->belongsTo(role::class);
    }
    
    public function unitUsaha(){
        return $this->belongsTo(UnitUsaha::class);
    }
}
