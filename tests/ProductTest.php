<?php

class ProductTest extends TestCase
{
    public function testCreate()
    {
        $response = $this->post('v1/product',[
            'productName'           => 'Shoes',
            'productDescription'    => 'The best shoes of the year',
            'productPrice'          => 150000,
            'productStock'          => 23,
        ],['content-type'  => 'application/json']);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'code',
            'description'
        ]); 
    }

    public function testGetAll()
    {
        $response = $this->get('v1/product',[]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'code',
            'description',
            'results'   => ['*' => 
                [
                    'productId',
                    'productName',
                    'productPrice',
                    'productStock',
                    'createdAt'
                ]
            ]
        ]); 
    }

    public function testGetDetail()
    {
        $response = $this->get('v1/product/1',[]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'code',
            'description',
            'results'   => [
                    'productId',
                    'productName',
                    'productPrice',
                    'productStock',
                    'createdAt'
                
            ]
        ]); 
    }

    public function testUpdated()
    {
        $response = $this->put('v1/product',[
            'productId'             => 1,
            'productName'           => 'New Shoes',
            'productDescription'    => 'The best New shoes of the year',
            'productPrice'          => 120000,
            'productStock'          => 30,
        ],['content-type'  => 'application/json']);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'code',
            'description'
        ]); 
    }

    public function testDelete()
    {
        $response = $this->delete('v1/product',[
            'productId'             => 1,
            ],['content-type'  => 'application/json']);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'code',
            'description'
        ]); 
    }
}