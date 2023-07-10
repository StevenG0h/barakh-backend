<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait TransactionTrait{
        public function CreateTransactionValidator(Array $data){
            $validator = Validator::make($data,[
                'transactionType'=>'required',
                'kelurahan_id'=>'required',
                'client_id'=>'required',
                'transactionAddress'=>'required',
                'product.*.productData.id'=>'required',
                'product.*.productData.productPrice'=>'required',
                'product.*.item'=>'required'
            ]);
            return $validator;
        }

        public function CreateTransactionFormatter(Array $data, $transactionData){
            $salesTransaction = [];
            for($i=0; $i<count($data['product']);$i++){
                $transaction['transaction_id']= $data['transaction_id'];
                $transaction['kelurahan_id']= $data['kelurahan_id'];
                $transaction['client_id']= $data['client_id'];
                $transaction['product_id'] = $data['product'][$i]['productData']['id'];
                $transaction['productCount'] = $data['product'][$i]['item'];
                $transaction['productPrice'] = $data['product'][$i]['productData']['productPrice'];
                $transaction['transactionAddress'] = $data['transactionAddress'];
                $transaction['transactionAmount']= $data['product'][$i]['productData']['productPrice'];
                array_push($salesTransaction,$transaction);
            }
            return $salesTransaction;
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