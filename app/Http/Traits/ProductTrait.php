<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait ProductTrait{
        public function CreateProductValidator(Array $data){
            $validator = Validator::make($data,[
                'productName'=>'required',
                'productDesc'=>'required',
                'productImage'=>'required',
                'productPrice'=>'required',
                'categoryId'=>'required',
                'usahaId'=>'required'
            ]);
            return $validator;
        }

        public function UpdateProductValidator(Array $data){
            $validator = Validator::make($data,[
                'productName'=>'sometimes',
                'productDesc'=>'sometimes',
                'productImage'=>'sometimes',
                'productPrice'=>'sometimes',
                'categoryId'=>'sometimes',
                'usahaId'=>'sometimes'
            ]);
            return $validator;
        }
    }