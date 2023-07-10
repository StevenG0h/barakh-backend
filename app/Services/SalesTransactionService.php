<?php 
    namespace App\Services;

use App\Http\Traits\SalesTransactionTrait;
use App\Models\salesTransaction;
use App\Models\Transaction;

    class SalesTransactionService{
        use SalesTransactionTrait;

        public function createTransaction(Array $data): salesTransaction{
            $validation = $this->CreateSalesTransactionValidator($data)->validate();
            $transaction = SalesTransaction::create($validation);
            return $transaction;
        }

        public function updateTransaction($id, Array $data): salesTransaction{
            $validation =  $this->UpdateSalesTransactionValidator($data)->validate();
            $transaction = SalesTransaction::findOrFail($id);
            $transaction->update($validation);
            return $transaction;
        }

        public function deleteTransaction($id): SalesTransaction{
            $transaction = SalesTransaction::findOrFail($id);
            $transaction->delete();
            return $transaction;
        }
    }
?>