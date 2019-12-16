<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function showAll();
    public function findById($id);
    public function createProduct(array $data);
    public function updateProduct($id, array $data);
    public function deleteProduct($id);
}