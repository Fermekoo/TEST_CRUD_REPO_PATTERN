<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Product;
use DB;
use Log;
class ProductRepository implements ProductInterface
{
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function showAll()
    {
        $products = $this->product->get();
        return $products;
    }

    public function findById($id)
    {
        $product = $this->product->findOrfail($id);

        return $product;
    }

    public function createProduct(array $data)
    {
        DB::beginTransaction();

        try{
            $this->product->create([
                'product_name'  => $data['productName'],
                'description'   => $data['productDescription'],
                'price'         => $data['productPrice'],
                'stock'         => $data['productStock']
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }

        DB::commit();
        return true;
    }

    public function updateProduct($id, array $data)
    {
        $product = $this->product->findOrFail($id);
        
        DB::beginTransaction();
        try{
            $product->product_name = (array_key_exists('productName',$data)) ? $data['productName'] : $product->product_name;
            $product->description  = (array_key_exists('productDescription',$data)) ? $data['productDescription'] : $product->description;
            $product->price        = (array_key_exists('productPrice',$data)) ? $data['productPrice'] : $product->price;
            $product->stock        = (array_key_exists('productStock',$data)) ? $data['productStock'] : $product->stock;
            $product->save();
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }

        DB::commit();
        return true;
    }

    public function deleteProduct($id)
    {
        DB::beginTransaction();
        try{
            $this->product->where('id',$id)->delete();
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }

        DB::commit();
        return true;
    }
}