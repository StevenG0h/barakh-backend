<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait TransactionTrait{
        public function CreateTransactionValidator(Array $data){
            $validator = Validator::make($data,[
                'transactionType'=>'required',
                'kelurahan_id'=>'required',
                'transactionAddress'=>'required',
                'product_id'=>'required',
                'productPrice'=>'required',
                'productCount'=>'required',
                'client_id'=>'required',
                'admin_id'=>'required',
                'transactionStatus'=>'required'
            ]);
            return $validator;
        }
       
        public function CreateOtherTransactionValidator(Array $data){
            $validator = Validator::make($data,[
                'transactionType'=>'required',
                'usaha_id'=>'required',
                'admin_id'=>'required',
                'transactionAmount'=>'required',
                'transactionNote'=>'required',
                'transactionTitle'=>'required'
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