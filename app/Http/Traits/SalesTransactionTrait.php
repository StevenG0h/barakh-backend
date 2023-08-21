<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait SalesTransactionTrait{
        public function CreateSalesTransactionValidator(Array $data){
            $validator = Validator::make($data,[
                'transaction_id'=>'required',
                'client_id'=>'required',
                'kelurahan_id'=>'required',
                'kecamatan_id'=>'required',
                'kota_id'=>'required',
                'provinsi_id'=>'required',
                'product_id'=>'required',
                'productCount'=>'required',
                'productPrice'=>'required',
                'transactionAddress'=>'required',
                'transactionAmount'=>'required',
            ]);
            return $validator;
        }

        // public function CreateTransactionFormatter(Array $data, $transactionData){
        //     $salesTransaction = [];
        //     for($i=0; $i<count($data['product']);$i++){
        //         $transaction['transaction_id']= $data['transaction_id'];
        //         $transaction['kelurahan_id']= $data['kelurahan_id'];
        //         $transaction['client_id']= $data['client_id'];
        //         $transaction['product_id'] = $data['product'][$i]['productData']['id'];
        //         $transaction['productCount'] = $data['product'][$i]['item'];
        //         $transaction['productPrice'] = $data['product'][$i]['productData']['productPrice'];
        //         $transaction['transactionAddress'] = $data['transactionAddress'];
        //         $transaction['transactionAmount']= $data['product'][$i]['productData']['productPrice'];
        //         array_push($salesTransaction,$transaction);
        //     }
        //     return $salesTransaction;
        // }
        
        public function UpdateSalesTransactionValidator(Array $data){
            $validator = Validator::make($data,[
                'transaction_id'=>'sometimes',
                'client_id'=>'sometimes',
                'product_id'=>'sometimes',
                'productCount'=>'sometimes',
                'productPrice'=>'sometimes',
                'transactionAddress'=>'sometimes',
                'transactionAmount'=>'sometimes',
            ]);
            return $validator;
        }
    }