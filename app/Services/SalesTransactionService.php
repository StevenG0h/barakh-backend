<?php 
    namespace App\Services;

use App\Http\Traits\SalesTransactionTrait;
use App\Models\Product;
use App\Models\salesTransaction;
use App\Models\Transaction;

    class SalesTransactionService{
        use SalesTransactionTrait;

        public function createTransaction(Array $data): salesTransaction{
            $validation = $this->CreateSalesTransactionValidator($data)->validate();
            $transaction = SalesTransaction::create($validation);
            $produk = Product::findOrFail($validation['product_id']);
            $produk->productStock = $produk->productStock - $validation['productCount'];
            $produk->save();
            return $transaction;
        }

        public function updateTransaction($id, Array $data): salesTransaction{
            $validation =  $this->UpdateSalesTransactionValidator($data)->validate();
            $transaction = SalesTransaction::findOrFail($id);
            $count =  $validation['productCount'] - $transaction->productCount;
            $transaction->update($validation);
            $produk = Product::findOrFail($transaction['product_id']);
            $produk->productStock = $produk->productStock - $count;
            $produk->save();
            return $transaction;
        }

        public function deleteTransaction($id): SalesTransaction{
            $transaction = SalesTransaction::findOrFail($id);
            $transaction->delete();
            return $transaction;
        }
    }
?>