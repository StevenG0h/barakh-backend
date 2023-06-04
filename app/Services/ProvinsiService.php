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

        public function updateProvinsi($id,Array $data): Provinsi{
            $validation =  $this->UpdateProvinsiValidator($data)->validate();
            $provinsi = Provinsi::findOrFail($id);
            $provinsi->update($validation);
            return $provinsi;
        }

        public function deleteProvinsi($id): Provinsi{
            $provinsi = Provinsi::findOrFail($id);
            $provinsi->delete();
            return $provinsi;
        }
    }
?>