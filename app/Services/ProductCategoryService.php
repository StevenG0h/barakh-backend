<?php 
    namespace App\Services;

use App\Http\Traits\ProductCategoryTrait;
use App\Models\ProductCategory;

    class ProductCategoryService{
        use ProductCategoryTrait;

        public function createProductCategory(Array $data): ProductCategory{
            $validation =  $this->createProductCategoryValidator($data)->validate();
            $productCategory = ProductCategory::create($validation);
            return $productCategory;
        }

        public function updateProductCategory($id,Array $data): ProductCategory{
            $validation =  $this->UpdateProductCategoryValidator($data)->validate();
            $productCategory = ProductCategory::findOrFail($id);
            $productCategory->update($validation);
            return $productCategory;
        }

        public function deleteProductCategory($id): ProductCategory{
            $productCategory = ProductCategory::findOrFail($id);
            $productCategory->delete();
            return $productCategory;
        }
    }
?>