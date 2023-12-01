<?php 
    namespace App\Services;

use App\Http\Traits\SalesTransactionTrait;
use App\Models\Product;
use App\Models\salesTransaction;
use App\Models\Transaction;

    class SalesTransactionService{
        use SalesTransactionTrait;

        public function createTransaction(Array $data){
            $validation = $this->CreateSalesTransactionValidator($data)->validate();
            $salesTransaction = SalesTransaction::create($validation);
            $count =  $validation['productCount'] - $salesTransaction->productCount;
            $produk = Product::findOrFail($validation['product_id']);
            if(($produk->productStock - $count) < 0){
                return response([
                    'error' => [
                        'msg' => 'Stok tidak cukup'
                    ]
                ],400);
            }
            $produk->productStock = $produk->productStock - $validation['productCount'];
            $produk->save();
            $transaction = Transaction::findOrFail($salesTransaction->transaction_id);
            $transaction->touch();
            return $salesTransaction;
        }

        public function updateTransaction($id, Array $data){
            $validation =  $this->UpdateSalesTransactionValidator($data)->validate();
            $salesTransaction = SalesTransaction::findOrFail($id);
            $count =  $validation['productCount'] - $salesTransaction->productCount;
            $produk = Product::findOrFail($salesTransaction['product_id']);
            if(($produk->productStock - $count) < 0){
                return response([
                    'error' => [
                        'msg' => 'Stok tidak cukup'
                    ]
                ],400);
            }
            $salesTransaction->update($validation);
            $produk->productStock = $produk->productStock - $count;
            $produk->save();
            $transaction = Transaction::findOrFail($salesTransaction->transaction_id);
            $transaction->touch();
            return response($salesTransaction,200);
        }

        public function deleteTransaction($id): SalesTransaction{
            $salesTransaction = SalesTransaction::findOrFail($id);
            $salesTransaction->delete();
            return $salesTransaction;
        }
    }
?>