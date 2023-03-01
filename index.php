<!DOCTYPE html>
<html lang="en">
<?php include('components/head.php'); ?>
<body>
    <!-- Navigation-->
    <?php include('components/nav.php'); ?>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Tienda en Linea</h1>
                <p class="lead fw-normal text-white-50 mb-0">Investigación Aplicada I</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <!---Comienza carta--->
                <?php 
                    $data = simplexml_load_file('productos.xml');

                    foreach($data as $producto){

                ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="<?php echo $producto->imagen; ?>" alt="..." />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder"><?= $producto->nombre ?></h5>
                                <!-- Product price-->
                                
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <form class="text-center">
                                <a class="btn btn-outline-dark mt-auto" href="carrito.php?product=<?= $producto->nombre?>">Agregar al carrito</a>
                    </form>
                        </div>
                    </div>
                </div>
                <?php 
            }
            ?>
                <!---Termina carta--->
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Investigación Aplicada I</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>