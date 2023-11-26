<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait TransactionTrait{
        public function CreateSpendingTransaction(Array $data){
            $validator = Validator::make($data,[
                'transactionType'=>'required',
                'unit_usaha_id'=>'required',
                'SpendingName'=>'required',
                'SpendingDescription'=>'required',
                'SpendingValue'=>'required',
                'create_time'=>'required'
            ]);
            return $validator;
        }
        
        public function UpdateSpendingTransactionValidator(Array $data){
            $validator = Validator::make($data,[
                'id'=>'required',
                'transactionType'=>'sometimes',
                'unit_usaha_id'=>'sometimes',
                'SpendingName'=>'sometimes',
                'SpendingDescription'=>'sometimes',
                'SpendingValue'=>'sometimes',
                'create_time'=>'sometimes'
            ]);
            return $validator;
        }

        public function CreateTransactionValidator(Array $data){
            $validator = Validator::make($data,[
                'transactionType'=>'required',
                'provinsi_id'=>'required',
                'kota_id'=>'required',
                'kecamatan_id'=>'required',
                'kelurahan_id'=>'required',
                'client_id'=>'required',
                'transactionAddress'=>'required',
                'product.*.productData.id'=>'required',
                'product.*.productData.unit_usaha_id'=>'required',
                'product.*.productData.productPrice'=>'required',
                'product.*.item'=>'required'
            ]);
            return $validator;
        }

        public function CreateTransactionFormatter(Array $data, $transactionData){
            $salesTransaction = [];
            for($i=0; $i<count($data['product']);$i++){
                $transaction['transaction_id']= $data['transaction_id'];
                $transaction['provinsi_id']= $data['provinsi_id'];
                $transaction['kota_id']= $data['kota_id'];
                $transaction['kecamatan_id']= $data['kecamatan_id'];
                $transaction['kelurahan_id']= $data['kelurahan_id'];
                $transaction['client_id']= $data['client_id'];
                $transaction['unit_usaha_id'] = $data['product'][$i]['productData']['unit_usaha_id'];
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