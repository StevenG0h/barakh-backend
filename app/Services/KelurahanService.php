<?php 
    namespace App\Services;

use App\Http\Traits\KelurahanTrait;
use App\Models\Kelurahan;

    class KelurahanService{
        use KelurahanTrait;

        public function createKelurahan(Array $data): Kelurahan{
            $validation =  $this->CreateKelurahanValidator($data)->validate();
            $kelurahan = Kelurahan::create($validation);
            
            return $kelurahan;
        }
    }
?>