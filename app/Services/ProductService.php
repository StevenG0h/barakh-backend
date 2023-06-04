<?php 
    namespace App\Services;

use App\Http\Traits\ProductTrait;
use App\Models\Product;

    class ProductService{
        use ProductTrait;

        public function createProduct(Array $data): Product{
            $validation =  $this->createProductValidator($data)->validate();
            $product = Product::create($validation);
            return $product;
        }

        public function updateProduct($id,Array $data): Product{
            $validation =  $this->UpdateProductValidator($data)->validate();
            $product = Product::findOrFail($id);
            $product->update($validation);
            return $product;
        }

        public function deleteProduct($id): Product{
            $product = Product::findOrFail($id);
            $product->delete();
            return $product;
        }
    }
?>