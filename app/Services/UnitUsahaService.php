<?php 
    namespace App\Services;

use App\Http\Traits\UnitUsahaTrait;
use App\Models\UnitUsaha;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

    class UnitUsahaService{
        use UnitUsahaTrait;

        public function createUnitUsaha(Array $data, $file, $logo){
            DB::beginTransaction();
            try{
                $unitUsahaLength= UnitUsaha::get();
                $validation =  $this->createUnitUsahaValidator($data)->validate();
                $storage = Storage::putFileAs('public/unitUsaha/', $validation['usahaImage'], $validation['usahaName'].'.'.$file->getClientOriginalExtension());
                $storage = Storage::putFileAs('public/unitUsaha/logo/', $validation['unitUsahaLogo'], $validation['usahaName'].'.'.$file->getClientOriginalExtension());
                $validation['usahaImage'] = $validation['usahaName'].'.'.$file->getClientOriginalExtension();
                $validation['unitUsahaLogo'] = $validation['usahaName'].'logo'.'.'.$logo->getClientOriginalExtension();
                $unitUsaha = UnitUsaha::create($validation);
                $data['unit_usaha_id'] = $unitUsaha->id;
                $data['orders'] = count($unitUsahaLength);
                DB::commit();
                return $unitUsaha;
            }catch(Exception $e){
                DB::rollBack();
                return $e;
            }
        }

        public function updateUnitUsaha($id,Array $data, $file, $logo):UnitUsaha{
            $validation =  $this->UpdateUnitUsahaValidator($data)->validate();
            $unitUsaha = UnitUsaha::findOrFail($id);
            if(gettype($validation['usahaImage']) != 'string'){
                try{
                    Storage::delete('public/unitUsaha/'.$unitUsaha->usahaImage);
                }catch(Exception $e){

                }
                $storage = Storage::putFileAs('public/unitUsaha/', $validation['usahaImage'], $validation['usahaName'].'.'.$file->getClientOriginalExtension());
                $validation['usahaImage'] = $validation['usahaName'].'.'.$file->getClientOriginalExtension();
            }
            if(gettype($validation['unitUsahaLogo']) != 'string'){
                try{
                    Storage::delete('public/unitUsaha/logo/'.$unitUsaha->unitUsahaLogo);
                }catch(Exception $e){

                }
                $storage = Storage::putFileAs('public/unitUsaha/logo/', $validation['unitUsahaLogo'], $validation['usahaName'].'logo'.'.'.$logo->getClientOriginalExtension());
                $validation['unitUsahaLogo'] = $validation['usahaName'].'logo.'.$logo->getClientOriginalExtension();
            }
            $unitUsaha->update($validation);
            return $unitUsaha;
        }

        public function deleteUnitUsaha($id): UnitUsaha{
            $unitUsaha = UnitUsaha::findOrFail($id);
            $unitUsaha->isActive = 0;
            $unitUsaha->save();
            return $unitUsaha;
        }
    }
?>