<?php

session_start();

interface TContext {
    public function addToCart($idProduct);
    public function removeFromCart($idProduct);
    public function pay();
    public function done();
    public function getProductQuantity($idProduct);
    public function calculateTotalPrice();
}

class AppContext implements TContext {
    public $cart = [];
    public $paid = false;
    public $products = null;
    public $loading = false;
    public $error = "";

    private $router;

    public function __construct($router) {
        $this->router = $router;
        $this->getProducts();
    }

    public function addToCart($idProduct) {
        $found = false;
        foreach ($this->cart as &$item) {
            if ($item['id'] === $idProduct) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }
        if (!$found) {
            foreach ($this->products as $product) {
                if ($product['id'] === $idProduct && $product['qty'] > 0) {
                    $this->cart[] = [
                        'id' => $product['id'],
                        'quantity' => 1,
                        'thumbnail' => $product['thumbnail'],
                        'title' => $product['title'],
                        'description' => $product['description'],
                        'price' => $product['price']
                    ];
                    $product['qty']--;
                    break;
                }
            }
        }
    }
    
    public function removeFromCart($idProduct) {
        foreach ($this->cart as $key => &$item) {
            if ($item['id'] === $idProduct) {
                if ($item['quantity'] > 1) {
                    $item['quantity']--;
                } else {
                    unset($this->cart[$key]);
                }
                break;
            }
        }
    }
    
    public function pay() {
        $this->paid = true;
        $this->cart = [];
    }
    
    public function done() {
        $this->paid = false;
    }
    
    public function getProductQuantity($idProduct) {
        foreach ($this->products as &$product) {
            if ($product['id'] === $idProduct) {
                if ($this->router->pathname === "/") {
                    $product['qty']--;
                } else if ($this->router->pathname === "/cart") {
                    $product['qty']++;
                }
                break;
            }
        }
    }
    
    public function calculateTotalPrice() {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['quantity'] > 1 ? $item['price'] * $item['quantity'] : $item['price'];
        }
        return $total;
    }
    
    private function getProducts() {
        $this->loading = true;
        try {
            if(isset($_SESSION['products'])) {
                $this->products = $_SESSION['products'];
            }else{
                $response = file_get_contents("https://mockend.up.railway.app/api/products");
                $data = json_decode($response, true);
                $this->products = $data;
                $_SESSION['products'] = $this->products;
            }
            $this->loading = false;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            $this->loading = false;
        }
    }
}

class Router {
    public $pathname;

    public function __construct($pathname) {
        $this->pathname = $pathname;
    }
}

$router = new Router("/");  
$appContext = new AppContext($router);