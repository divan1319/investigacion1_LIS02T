<?php 
session_start();
$product = $_GET['product'];

if(empty($product)){
header("Location: ./");
}else{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        
    }
    
    if (!isset($_SESSION['cart'][$product])) {
        $_SESSION['cart'][$product] = 0;
        
    }
    $_SESSION['cart'][$product]++;
}

//echo "<pre>";print_r($_SESSION['cart']);echo "</pre>";

?>
<!DOCTYPE html>
<html lang="en">
<?php include('components/head.php'); ?>

<body>
    <?php include('components/nav.php'); ?>
    <div class="container-fluid mt-5">
        <div class="card">
            <h5 class="card-header">Carrito</h5>
            <div class="card-body">


                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" colspan="5">Producto</th>
                            <th scope="col">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $products => $quantity){
        
        ?>
                        <tr>
                            <th scope="row" colspan="5"><?= $products;?></th>
                            <td><?= $quantity;?></td>
                        </tr>
                        <?php 
    }
    ?>
                    </tbody>
                </table>
                <a href="contacto.php" class="btn btn-primary mt-2">Cotizar</a>
                <a href="./" class="btn btn-secondary mt-2">Seguir Comprando</a>
            </div>
        </div>
    </div>
</body>

</html>
<?php









?>