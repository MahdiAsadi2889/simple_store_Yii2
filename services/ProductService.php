<?php

namespace app\services;

use app\models\Product;
use RuntimeException;
use yii\web\NotFoundHttpException;

class ProductService
{
    public function create(Product $product): bool
    {
        if (!$product->validate()) {
            return false;
        }

        return $product->save(false);
    }

    public function update(Product $product): bool
    {
        if (!$product->validate()) {
            return false;
        }

        return $product->save(false);
    }

    public function delete(Product $product): void
    {
        if ($product->delete() === false) {
            throw new RuntimeException('Failed to delete product');
        }
    }

    public function findById(int $id): Product
    {
        $product = Product::findOne($id);
        if ($product === null) {
            throw new NotFoundHttpException('Product not found');
        }
        return $product;
    }
}
