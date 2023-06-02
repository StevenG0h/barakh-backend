<?php 
    namespace App\Http\Traits;
    use Illuminate\Http\Request;

    trait ProductTrait{
        public function CreateProductValidator(Request $data){
            $validator = $data->validate([
                'productName'=>'required',
                'productDesc'=>'required',
                'productImage'=>'required',
                'productPrice'=>'required',
                'categoryId'=>'required',
                'usahaId'=>'required'
            ]);
            return $validator;
        }
    }