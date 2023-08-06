<?php 
    namespace App\Services;

use App\Http\Traits\GaleriTrait;
use App\Models\Galeri;
use Exception;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

    class GaleriService{
        use GaleriTrait;

        public function createGaleri(Array $data, $file): galeri{
            $validation =  $this->createGaleriValidator($data)->validate();
            $storage = Storage::putFileAs('public/galeri/', $validation['path'], $validation['galeriTitle'].'.'.$file['path']->getClientOriginalExtension());
            $validation['path'] = $validation['galeriTitle'].'.'.$file['path']->getClientOriginalExtension();
            $galeri = Galeri::create($validation);
            return $galeri;
        }

        public function updateGaleri($id,Array $data, $file): galeri{
            $validation =  $this->UpdateGaleriValidator($data)->validate();
            $galeri = Galeri::findOrFail($id);
            if(gettype($validation['path']) != 'string'){
                try{
                    Storage::delete('public/galeri/'.$galeri->path);
                }catch(Exception $e){

                }
                $storage = Storage::putFileAs('public/galeri/', $validation['path'], $validation['galeriTitle'].'.'.$file['path']->getClientOriginalExtension());
                $validation['path'] = $validation['galeriTitle'].'.'.$file['path']->getClientOriginalExtension();
            }
            $galeri->update($validation);
            return $galeri;
        }

        public function deleteGaleri($id): Galeri{
            $galeri = Galeri::findOrFail($id);
            Storage::delete('public/galeri/'.$galeri->path);
            $galeri->delete();
            return $galeri;
        }
    }
?>