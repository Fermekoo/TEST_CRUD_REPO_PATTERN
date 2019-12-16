<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use App\Transformers\ProductTransformer;
use Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $product;
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function showAll()
    {
        $products = $this->product->showAll();
        $data     = fractal()->collection($products)->transformWith(new ProductTransformer)->toArray();

        return $this->trueResponse('list product', 200, $data['data']);
    }

    public function detail($id)
    {
        $product = $this->product->findById($id);
        $data    = fractal()->item($product)->transformWith(new ProductTransformer)->toArray();

        return $this->trueResponse('detail product', 200, $data['data']);

    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productName'           => 'required',
            'productDescription'    => '',
            'productPrice'          => 'required|numeric',
            'productStock'          =>'required|numeric',
            
        ]);
        if($validator->fails()){
            $validation = $this->validatorMessage($validator);
            
            return $this->trueResponse($validation['msg'], 400, $validation['data']);
        }

        $data = [
            'productName'           => strip_tags($request->productName),
            'productDescription'    => $request->productDescription,
            'productPrice'          => strip_tags($request->productPrice),
            'productStock'          => strip_tags($request->productStock)
        ];

        $save = $this->product->createProduct($data);
        if($save){
            return $this->trueResponse('product created successfully', 201);
        }
        return $this->trueResponse('Failed to create product', 422);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productId'             => 'required|exists:product,id',
            'productName'           => 'required',
            'productDescription'    => '',
            'productPrice'          => 'required|numeric',
            'productStock'          =>'required|numeric',
            
        ]);
        if($validator->fails()){
            $validation = $this->validatorMessage($validator);
            
            return $this->trueResponse($validation['msg'], 400, $validation['data']);
        }

        $data = [
            'productName'           => strip_tags($request->productName),
            'productDescription'    => $request->productDescription,
            'productPrice'          => strip_tags($request->productPrice),
            'productStock'          => strip_tags($request->productStock)
        ];

        $update = $this->product->updateProduct($request->productId, $data);

        if($update){
            return $this->trueResponse('product updated successfully', 201);
        }
        return $this->trueResponse('Failed to update product', 422);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productId'             => 'required|exists:product,id',
        ]);
        if($validator->fails()){
            $validation = $this->validatorMessage($validator);
            
            return $this->trueResponse($validation['msg'], 400, $validation['data']);
        }

        $delete = $this->product->deleteProduct($request->productId);

        if($delete){
            return $this->trueResponse('product deleted successfully', 201);
        }
        return $this->trueResponse('Failed to delete product', 422);
    }
}