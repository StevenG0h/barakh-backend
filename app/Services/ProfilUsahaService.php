<?php 
    namespace App\Services;

use App\Http\Traits\ProfilUsahaTrait;
use App\Models\ProfilUsaha;
use App\Models\ProfilUsahaImages;
use Illuminate\Support\Facades\Storage;

    class ProfilUsahaService{
        use ProfilUsahaTrait;

        public function createProfilUsaha(Array $data){
            $validation =  $this->CreateProfilValidator($data)->validate();
            $profil = ProfilUsaha::create($validation);
            Storage::makeDirectory('public/profil/'.$profil->id);
            for($i=0; $i<count($validation['profilUsahaImages']); $i++){
                $profilImageData = [
                    'profil_usaha_id'=> $profil->id,
                    'order'=>$i,
                    'path'=>$profil->id."/".$validation['profilUsahaImages'][$i]->getClientOriginalName(),
                ];
                $profilImage = ProfilUsahaImages::create($profilImageData);
                Storage::putFileAs('public/profil/'.$profil->id, $validation['profilUsahaImages'][$i], $validation['profilUsahaImages'][$i]->getClientOriginalName());
                
            }
            return $data;
        }

        public function updateProfilUsaha($id,Array $data){
            if(!isset($data['id'])){
                return $this->createProfilUsaha($data);
            }
            $validation =  $this->UpdateProfilValidator($data)->validate();
            $profil = ProfilUsaha::findOrFail($id);
            $profil->update($validation);
            if(isset($validation['deletedImage'])){
                for($i=0; $i<count($validation['deletedImage']); $i++){
                    $profilImage = ProfilUsahaImages::findOrFail($validation['deletedImage'][$i]);
                    if(!empty($profilImage->path)){
                        Storage::delete('public/profil/'.$profilImage->path);
                        $profilImage->delete();
                    }
                }
            }
            if(!empty($validation['profilUsahaImages'])){
                for($i=0; $i<count($validation['profilUsahaImages']); $i++){
                    if(gettype($validation['profilUsahaImages'][$i]) === 'object'){
                        $profilImage = ProfilUsahaImages::where('profil_usaha_id',$id)->where('order',$i)->first();
                        if(!empty($profilImage->path)){
                            Storage::delete('public/profil/'.$profilImage->path);
                            $profilImage->path = $profil->id."/".$validation['profilUsahaImages'][$i]->getClientOriginalName();
                            $profilImage->save();
                            Storage::putFileAs('public/profil/'.$profil->id, $validation['profilUsahaImages'][$i], $validation['profilUsahaImages'][$i]->getClientOriginalName());
                        }else{
                            $profilImageData = [
                                'profil_usaha_id'=> $profil->id,
                                'order'=>$i,
                                'path'=>$profil->id."/".$validation['profilUsahaImages'][$i]->getClientOriginalName(),
                            ];
                            $profilImage = ProfilUsahaImages::create($profilImageData);
                            Storage::putFileAs('public/profil/'.$profil->id, $validation['profilUsahaImages'][$i], $validation['profilUsahaImages'][$i]->getClientOriginalName());
                        }
                    }
                }
            }
            return $data;
        }

        public function deleteProfilUsaha($id): ProfilUsaha{
            $profil = ProfilUsaha::findOrFail($id);
            $profilImage = ProfilUsahaImages::where('profil_usaha_id',$id)->get();
            for($i = 0; $i<count($profilImage);$i++){
                Storage::delete('public/profil/'.$profilImage[$i]->path);
                $profilImage[$i]->delete();
            }
            $profil->delete();
            return $profil;
        }
        
    }
?>