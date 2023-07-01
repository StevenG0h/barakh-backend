<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait ProductTrait{
        public function CreateProductValidator(Array $data){
            $validator = Validator::make($data,[
                'productName'=>'required',
                'productDesc'=>'required',
                'productImages.*'=>'required|image',
                'productPrice'=>'required',
                'productStock'=>'required',
                'unit_usaha_id'=>'required'
            ]);
            return $validator;
        }

        public function UpdateProductValidator(Array $data){
            $validator = Validator::make($data,[
                'productName'=>'sometimes',
                'productDesc'=>'sometimes',
                'productImages.*'=>'sometimes',
                'productPrice'=>'sometimes',
                'productStock'=>'sometimes',
                'unit_usaha_id'=>'sometimes',
                'deletedImage'=>'sometimes'
            ]);
            return $validator;
        }
    }