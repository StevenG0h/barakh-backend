<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait ProductCategoryTrait{
        public function CreateProductCategoryValidator(Array $data){
            $validator = Validator::make($data,[
                'categoryName'=>'required',
                'categoryDesc'=>'required',
                'usahaId'=>'required'
            ]);
            return $validator;
        }
        public function UpdateProductCategoryValidator(Array $data){
            $validator = Validator::make($data,[
                'categoryName'=>'sometimes',
                'categoryDesc'=>'sometimes',
                'usahaId'=>'sometimes'
            ]);
            return $validator;
        }
    }