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

        public function createUnitUsaha(Array $data, $file):UnitUsaha{
            DB::beginTransaction();
            try{
                $pegawai = new UserService();
                $validation =  $this->createUnitUsahaValidator($data)->validate();
                $adminValidation = $pegawai->CreateAdminValidator($data)->validate();
                $storage = Storage::putFileAs('public/unitUsaha/', $validation['usahaImage'], $validation['usahaName'].'.'.$file->getClientOriginalExtension());
                $validation['usahaImage'] = $validation['usahaName'].'.'.$file->getClientOriginalExtension();
                $unitUsaha = UnitUsaha::create($validation);
                $data['unit_usaha_id'] = $unitUsaha->id;
                $pegawai->createUser($data);
                DB::commit();
                return $unitUsaha;
            }catch(Exception $e){
                DB::rollBack();
            }
        }

        public function updateUnitUsaha($id,Array $data, $file):UnitUsaha{
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