<?php 
    namespace App\Http\Traits;
    use Illuminate\Http\Request;

    trait TestimonyTrait{
        public function CreateTestimonyValidator(Request $data){
            $validator = $data->validate([
                'transactionProvince'=>'required',
                'transactionCity'=>'required',
                'transactionDistrict'=>'required',
                'transactionAddress'=>'required',
                'productId'=>'required',
                'adminId'=>'required',
                'transactionStatus'=>'required'
            ]);
            return $validator;
        }
    }