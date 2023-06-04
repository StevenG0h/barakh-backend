<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait TransactionTrait{
        public function CreateTransactionValidator(Array $data){
            $validator = Validator::make($data,[
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
        
        public function UpdateTransactionValidator(Array $data){
            $validator = Validator::make($data,[
                'transactionProvince'=>'sometimes',
                'transactionCity'=>'sometimes',
                'transactionDistrict'=>'sometimes',
                'transactionAddress'=>'sometimes',
                'productId'=>'sometimes',
                'adminId'=>'sometimes',
                'transactionStatus'=>'sometimes'
            ]);
            return $validator;
        }
    }