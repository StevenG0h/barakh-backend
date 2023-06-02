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
    }
?>