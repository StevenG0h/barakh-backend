<?php 
    namespace App\Services;

use App\Http\Traits\TransactionTrait;
use App\Models\Transaction;

    class TransactionService{
        use TransactionTrait;

        public function createTransaction(Array $data): Transaction{
            $validation =  $this->createTransactionValidator($data)->validate();
            $transaction = Transaction::create($validation);
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