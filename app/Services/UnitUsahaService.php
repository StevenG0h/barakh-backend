<?php 
    namespace App\Services;

use App\Http\Traits\UnitUsahaTrait;
use App\Models\UnitUsaha;

    class UnitUsahaService{
        use UnitUsahaTrait;

        public function createUnitUsaha(Array $data): unitUsaha{
            $validation =  $this->createUnitUsahaValidator($data)->validate();
            $unitUsaha = UnitUsaha::create($validation);
            return $unitUsaha;
        }

        public function updateUnitUsaha($id,Array $data): UnitUsaha{
            $validation =  $this->UpdateUnitUsahaValidator($data)->validate();
            $unitUsaha = UnitUsaha::findOrFail($id);
            $unitUsaha->update($validation);
            return $unitUsaha;
        }

        public function deleteUnitUsaha($id): UnitUsaha{
            $unitUsaha = UnitUsaha::findOrFail($id);
            $unitUsaha->delete();
            return $unitUsaha;
        }
    }
?>