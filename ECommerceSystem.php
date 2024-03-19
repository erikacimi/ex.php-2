<?php

class EcommerceSystem
{
    private $productsUrl = "https://mockend.up.railway.app/api/products";
    private $products = array();
    private $cart = array(); 

    public function __construct()
    {
        $this->fetchProducts();
    }

    private function fetchProducts()
    {
        $response = file_get_contents($this->productsUrl);
        $productsData = json_decode($response, true);

        foreach ($productsData as $productData) {
            $product = new stdClass();
            $product->id = $productData['id'];
            $product->name = $productData['name'];
            $product->description = $productData['description'];
            $product->price = $productData['price'];
            $product->quantity = $productData['quantity'];
            $this->products[$product->id] = $product;
        }
    }

    public function displayProducts()
    {
        $productList = [];
        foreach ($this->products as $product) {
            $productList[] = array(
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => $product->quantity
            );
        }
        return $productList;
    }

    public function getProduct($productId)
    {
        if (isset($this->products[$productId])) {
            return $this->products[$productId];
        } else {
            return null;
        }
    }

    public function addProduct($productData)
    {
        $product = new stdClass();
        $product->id = $productData['id'];
        $product->name = $productData['name'];
        $product->description = $productData['description'];
        $product->price = $productData['price'];
        $product->quantity = $productData['quantity'];

        $this->products[$product->id] = $product;
    }

    public function updateProduct($productId, $productData)
    {
        if (isset($this->products[$productId])) {
            $product = $this->products[$productId];
            $product->name = $productData['name'];
            $product->description = $productData['description'];
            $product->price = $productData['price'];
            $product->quantity = $productData['quantity'];

            $this->products[$productId] = $product;
            return true;
        } else {
            return false;
        }
    }

    public function deleteProduct($productId)
    {
        if (isset($this->products[$productId])) {
            unset($this->products[$productId]);
            return true;
        } else {
            return false;
        }
    }
}

?>
