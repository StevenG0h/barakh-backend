<?php 
    namespace App\Services;

use App\Http\Traits\TransactionTrait;
use App\Models\IncomeTransaction;
use App\Models\salesTransaction;
use App\Models\Transaction;

    class TransactionService{
        use TransactionTrait;

        public function createTransaction(Array $data){
            $type = $data['transactionType'];
            if($type == "PENJUALAN"){
                $validation =  $this->createTransactionValidator($data)->validate();
                $transaction = Transaction::create($validation);
                $validation['transaction_id'] = $transaction->id;
                $formatted = $this->CreateTransactionFormatter($validation, $transaction);
                for($i=0;$i<count($formatted);$i++){
                    salesTransaction::create($formatted[$i]);
                }
                return response('',200);
            }else if($type == "PEMASUKANLAIN"){
                $validation =  $this->CreateOtherTransactionValidator($data)->validate();
                $transaction = Transaction::create($validation);
                $incomeData = $validation;
                $incomeData['transaction_id'] = $transaction->id;
                $income = IncomeTransaction::create($incomeData);
            }
            return $transaction;
        }

        public function updateTransaction($id,Array $data): Transaction{
            $validation =  $this->UpdateTransactionValidator($data)->validate();
            $transaction = Transaction::findOrFail($id);
            $transaction->update($validation);
            return $transaction;
        }

        public function deleteTransaction($id): Transaction{
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();
            return $transaction;
        }
    }
?>