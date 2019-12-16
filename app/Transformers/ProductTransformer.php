<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Product;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'productId'     => $product->id,
            'productName'   => strip_tags($product->product_name),
            'productPrice'  => (int)$product->price,
            'productStock'  => (int)$product->stock,
            'createdAt'     => $product->created_at->diffForHumans()
        ];
    }
}
