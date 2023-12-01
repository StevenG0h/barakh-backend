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
                'productDisc'=>'required',
                'satuan'=>'required',
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
                'productDisc'=>'sometimes',
                'productStock'=>'sometimes',
                'unit_usaha_id'=>'sometimes',
                'satuan'=>'sometimes',
                'deletedImage'=>'sometimes'
            ]);
            return $validator;
        }
    }