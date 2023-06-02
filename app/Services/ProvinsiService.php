<?php 
    namespace App\Services;

use App\Http\Traits\ProvinsiTrait;
use App\Models\Provinsi;

    class ProvinsiService{
        use ProvinsiTrait;

        public function createProvinsi(Array $data): provinsi{
            $validation =  $this->createProvinsiValidator($data)->validate();
            $provinsi = Provinsi::create($validation);
            
            return $provinsi;
        }
    }
?>