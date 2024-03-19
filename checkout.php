<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
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

    public function addToCart($productId, $quantity)
    {
        if (isset($this->products[$productId])) {
            $product = $this->products[$productId];

            if ($product->quantity >= $quantity && $quantity > 0) {
                if (isset($this->cart[$productId])) {
                    $this->cart[$productId]->quantity += $quantity;
                } else {
                    $this->cart[$productId] = (object) array(
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $quantity
                    );
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            return false;
        }

        $totalPrice = 0;
        foreach ($this->cart as $product) {
            $totalPrice += $product->price * $product->quantity;
        }

        $this->cart = array();

        return $totalPrice;
    }
}
$system = new EcommerceSystem();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $totalPrice = $system->checkout();
    
    if ($totalPrice !== false) {
?>
        <h1>Ordine completato!</h1>
        <p>Totale: <?php echo $totalPrice; ?> €</p>
        <p>Grazie per il tuo acquisto!</p>
<?php
    } else {
?>
        <h1>Errore durante il checkout</h1>
        <p>Si è verificato un problema durante il checkout. Riprova più tardi.</p>
<?php
    }
} else {
    header("Location: index.php");
    exit;
}

?>
</body>
</html>
