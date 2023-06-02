<?php 
    namespace App\Http\Traits\RelationTraits;

    use App\Models\Admin;
    use App\Models\transaction;

    trait AdminHasTransaction{
        public function adminTranscation(){
            $this->hasMany(transaction::class, "admin");
            return "hello";
        }
    }