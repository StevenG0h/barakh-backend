<?php 
    namespace App\Services;

use App\Http\Traits\KotaTrait;
use App\Models\Kota;

    class KotaService{
        use KotaTrait;

        public function createKota(Array $data): Kota{
            $validation =  $this->CreateKotaValidator($data)->validate();
            $kota = Kota::create($validation);
            
            return $kota;
        }
    }
?>