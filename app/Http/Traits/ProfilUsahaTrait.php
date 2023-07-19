<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait ProfilUsahaTrait{
        public function CreateProfilValidator(Array $data){
            $validator = Validator::make($data,[
                'unit_usaha_id'=>'required',
                'profil_usaha_desc'=>'required',
                'profilUsahaImages.*'=>'required|image',
            ]);
            return $validator;
        }

        public function UpdateProfilValidator(Array $data){
            $validator = Validator::make($data,[
                'profil_usaha_desc'=>'sometimes',
                'profilUsahaImages.*'=>'sometimes',
                'deletedImage'=>'sometimes'
            ]);
            return $validator;
        }
    }