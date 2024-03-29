<?php 
    namespace App\Services;

use App\Http\Traits\ProductTrait;
use App\Models\Product;
use App\Models\ProductImg;
use App\Models\rating;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Raw;

    class ProductService{
        use ProductTrait;

        public function createProduct(Array $data){
            $validation =  $this->createProductValidator($data)->validate();
            $product = Product::create($validation);
            Storage::makeDirectory('public/product/'.$product->id);
            for($i=0; $i<count($validation['productImages']); $i++){
                $productImageData = [
                    'product_id'=> $product->id,
                    'order'=>$i,
                    'path'=>$product->id."/".$validation['productImages'][$i]->getClientOriginalName(),
                ];
                $productImage = ProductImg::create($productImageData);
                Storage::putFileAs('public/product/'.$product->id, $validation['productImages'][$i], $validation['productImages'][$i]->getClientOriginalName());
            }
            return $data;
        }

        public function updateProduct($id,Array $data){
            $validation =  $this->UpdateProductValidator($data)->validate();
            $product = Product::findOrFail($id);
            $product->update($validation);
            if(isset($validation['deletedImage'])){
                for($i=0; $i<count($validation['deletedImage']); $i++){
                    $productImage = ProductImg::findOrFail($validation['deletedImage'][$i]);
                    if(!empty($productImage->path)){
                        Storage::delete('public/product/'.$productImage->path);
                        $productImage->delete();
                    }
                }
            }
            if(!empty($validation['productImages'])){
                for($i=0; $i<count($validation['productImages']); $i++){
                    if(gettype($validation['productImages'][$i]) === 'object'){
                        $productImage = ProductImg::where('product_id',$id)->where('order',$i)->first();
                        if(!empty($productImage->path)){
                            Storage::delete('public/product/'.$productImage->path);
                            $productImage->path = $product->id."/".$validation['productImages'][$i]->getClientOriginalName();
                            $productImage->save();
                            Storage::putFileAs('public/product/'.$product->id, $validation['productImages'][$i], $validation['productImages'][$i]->getClientOriginalName());
                        }else{
                            $productImageData = [
                                'product_id'=> $product->id,
                                'order'=>$i,
                                'path'=>$product->id."/".$validation['productImages'][$i]->getClientOriginalName(),
                            ];
                            $productImage = ProductImg::create($productImageData);
                            Storage::putFileAs('public/product/'.$product->id, $validation['productImages'][$i], $validation['productImages'][$i]->getClientOriginalName());
                        }
                    }
                }
            }
            $ordering = ProductImg::where('product_id',$id)->orderBy('order','asc')->get();
            for($i = 0; $i<count($ordering);$i++){
                $ordering[$i]->order = $i;
                $ordering[$i]->save();
            }
            return $data;
        }

        public function deleteProduct($id): Product{
            $product = Product::findOrFail($id);
            $productImage = ProductImg::where('product_id',$id)->get();
            for($i = 0; $i<count($productImage);$i++){
                Storage::delete('public/product/'.$productImage[$i]->path);
                $productImage[$i]->delete();
            }
            $product->isActive= 0;
            $product->save();
            return $product;
        }
        
        public function addRating($id, Array $data):rating{
            $product = Product::findOrFail($id);
            $rating = new rating();
            $rating->product_id = $id;
            $rating->rating = $data['rating'];
            $rating->save();
            return $rating;
        }
    }
?>