<?php 
    namespace App\Services;

use App\Http\Traits\UnitUsahaTrait;
use App\Models\UnitUsaha;
use Exception;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

    class UnitUsahaService{
        use UnitUsahaTrait;

        public function createUnitUsaha(Array $data, $file): unitUsaha{
            $validation =  $this->createUnitUsahaValidator($data)->validate();
            $storage = Storage::putFileAs('public/unitUsaha/', $validation['usahaImage'], $validation['usahaName'].'.'.$file->getClientOriginalExtension());
            $validation['usahaImage'] = $validation['usahaName'].'.'.$file->getClientOriginalExtension();
            $unitUsaha = UnitUsaha::create($validation);
            return $unitUsaha;
        }

        public function updateUnitUsaha($id,Array $data, $file): UnitUsaha{
            $validation =  $this->UpdateUnitUsahaValidator($data)->validate();
            $unitUsaha = UnitUsaha::findOrFail($id);
            if(!empty($validation['usahaImage'])){
                try{
                    Storage::delete('public/unitUsaha/'.$unitUsaha->usahaImage);
                }catch(Exception $e){

                }
                $storage = Storage::putFileAs('public/unitUsaha/', $validation['usahaImage'], $validation['usahaName'].'.'.$file->getClientOriginalExtension());
                $validation['usahaImage'] = $validation['usahaName'].'.'.$file->getClientOriginalExtension();
            }
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