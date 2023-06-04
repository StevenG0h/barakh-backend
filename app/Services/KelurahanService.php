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
        
        public function updateKelurahan($id,Array $data): Kelurahan{
            $validation =  $this->UpdateKelurahanValidator($data)->validate();
            $kelurahan = Kelurahan::findOrFail($id);
            $kelurahan->update($validation);
            return $kelurahan;
        }

        public function deleteKelurahan($id): Kelurahan{
            $kelurahan = Kelurahan::findOrFail($id);
            $kelurahan->delete();
            return $kelurahan;
        }
    }
?>