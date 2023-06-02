<?php 
    namespace App\Http\Traits;
    use Illuminate\Http\Request;

    trait ProductCategoryTrait{
        public function CreateProductCategoryValidator(Request $data){
            $validator = $data->validate([
                'categoryName'=>'required',
                'categoryDesc'=>'required',
                'usahaId'=>'required'
            ]);
            return $validator;
        }
    }