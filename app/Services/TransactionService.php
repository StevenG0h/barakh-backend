<?php 
    namespace App\Services;

use App\Http\Traits\TransactionTrait;
use App\Models\Admin;
use App\Models\IncomeTransaction;
use App\Models\Product;
use App\Models\salesTransaction;
use App\Models\SpendingTransaction;
use App\Models\Transaction;

    class TransactionService{
        use TransactionTrait;

        public function createTransaction(Array $data): Transaction{
            $type = $data['transactionType'];
            if($type == "PENJUALAN"){
                $validation =  $this->createTransactionValidator($data)->validate();
                $transaction = Transaction::create($validation);
                $validation['transaction_id'] = $transaction->id;
                $formatted = $this->CreateTransactionFormatter($validation, $transaction);
                for($i=0;$i<count($formatted);$i++){
                    salesTransaction::create($formatted[$i]);
                    $produk = Product::findOrFail($formatted[$i]['product_id']);
                    $produk->productStock = $produk->productStock - $formatted[$i]['productCount'];
                    $produk->save();
                    if($i == 0){
                        $phoneNumber = $produk->with(['unitUsaha.admin'=> function ($q) {
                            $q->inRandomOrder();
                        }])->whereRelation('unitUsaha.admin','adminLevel','=','0')->get();
                        if($phoneNumber->isEmpty()){
                            $phoneNumber = Admin::where('adminLevel','=','1')->get();
                        }
                        $transaction['adminNumber'] = $phoneNumber->first();
                    }
                }
                return $transaction;
            }else if($type == "PEMASUKANLAIN"){
                $validation =  $this->CreateOtherTransactionValidator($data)->validate();
                $transaction = Transaction::create($validation);
                $incomeData = $validation;
                $incomeData['transaction_id'] = $transaction->id;
                $income = IncomeTransaction::create($incomeData);
                return $transaction;
            }else if($type == "PENGELUARAN"){
                $validation = $this->CreateSpendingTransaction($data)->validate();
                $validation['transactionStatus'] = 'TERVERIFIKASI';
                $transaction = Transaction::create($validation);
                $spendingData = $validation;
                $spendingData['transaction_id'] = $transaction->id;
                $spending = SpendingTransaction::create($spendingData);
                return $transaction;
            }
        }

        public function updateTransaction($id,Array $data): Transaction{
            $validation =  $this->UpdateTransactionValidator($data)->validate();
            $transaction = Transaction::findOrFail($id);
            $transaction->update($validation);
            return $transaction;
        }
        
        public function updateSpendingTransaction($id,Array $data): SpendingTransaction{
            $validation =  $this->UpdateSpendingTransactionValidator($data)->validate();
            $transaction = SpendingTransaction::findOrFail($id);
            $transaction->update($validation);
            return $transaction;
        }

        public function deleteSpendingTransaction($id): Transaction{
            $transaction = Transaction::findOrFail($id);
            $transaction->spending()->delete();
            $transaction->delete();
            return $transaction;
        }
        
    }
?>