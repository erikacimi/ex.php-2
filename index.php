<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCommerce</title>
    <?php
    // Include i tuoi stili CSS generati tramite PHP
    require_once 'styles.php';
    require 'context.php';
    
    // Richiama gli stili CSS nel tag head
    echo getGridStyles();
    echo getContainerCardStyles();
    echo getContainerPriceQtyStyles();
    echo getContainerTitleAndDescriptionStyles();
    echo getDivCartStyles(false); // Passa true se vuoi gli stili per il carrello disabilitato
    ?>
</head>
<body>
    <?php 
        echo '<a href="http://localhost/ecommerce/index.php"><h1>Products</h1></a>';
        echo '<a href="http://localhost/ecommerce/cart.php"><h1>Cart</h1></a>';
        echo '<h1>Product</h1>';
    ?>
    <?php 
        $router = new Router("/index.php");  // Sostituisci con il percorso corretto
        $appContext = new AppContext($router);
    ?>
    <div class="Grid">
        <?php
        
        try{
        $appContext = new AppContext($router);
            if ($appContext->products) {
                foreach ($appContext->products as $product) {
                    echo '<div class="ContainerCard">';
                    echo '<img class="Thumbnail" src="' . $product['thumbnail'] . '" alt="Thumbnail">';
                    echo '<div class="ContainerTitleAndDescription">';
                    echo '<h2 class="Title">' . $product['title'] . '</h2>';
                    echo '<p class="Description">' . $product['description'] . '</p>';
                    echo '</div>';
                    echo '<div class="ContainerPriceQty">';
                    echo '<p class="Price">' . $product['price'] . ' €</p>';
                    echo '<p class="Quantity">Disponibili: ' . $product['qty'] . '</p>';
                    echo '</div>';
                    echo '<div class="DivCart" onClick="' . $appContext->addToCart($product['id']) . '"';
                    if ($product['qty'] === 0) {
                        getDivCartStyles(false);
                        echo ' disabled';
                    }
                    echo '>';
                    echo '<p>ADD TO CART</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "Nessun prodotto disponibile.";
            }
        }catch (Exception $e){
            echo "Si è verificato un errore nel caricamento dei dati dei prodotti: " . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>