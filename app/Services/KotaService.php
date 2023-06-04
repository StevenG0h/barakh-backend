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

        public function updateKota($id,Array $data): Kota{
            $validation =  $this->UpdateKotaValidator($data)->validate();
            $kota = Kota::findOrFail($id);
            $kota->update($validation);
            return $kota;
        }

        public function deleteKota($id): Kota{
            $kota = Kota::findOrFail($id);
            $kota->delete();
            return $kota;
        }
    }
?>