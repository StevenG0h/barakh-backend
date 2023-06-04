<?php 
    namespace App\Services;

use App\Http\Traits\KecamatanTrait;
use App\Models\kecamatan;

    class KecamatanService{
        use KecamatanTrait;

        public function createKecamatan(Array $data): kecamatan{
            $validation =  $this->CreateKecamatanValidator($data)->validate();
            $kecamatan = kecamatan::create($validation);
            
            return $kecamatan;
        }

        public function updateKecamatan($id,Array $data): kecamatan{
            $validation =  $this->UpdateKecamatanValidator($data)->validate();
            $kecamatan = kecamatan::findOrFail($id);
            $kecamatan->update($validation);
            return $kecamatan;
        }

        public function deleteKecamatan($id): kecamatan{
            $kecamatan = kecamatan::findOrFail($id);
            $kecamatan->delete();
            return $kecamatan;
        }
    }
?>