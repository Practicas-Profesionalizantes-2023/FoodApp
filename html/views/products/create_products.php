<?php
include_once "/var/www/html/models/productsmodel.php";
include_once "/var/www/html/models/providermodel.php";

$productsModel = new ProductsModel();
$products = $productsModel->getAll();
$nameOfProduct = array();
foreach ($products as $product) {
    $nameOfProduct[] = $product->getItemName();
}

$providerModel = new ProviderModel();
$providers = $providerModel->getAll();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
    <body>
        <div class="container">
            <h2 class="text-center mb-4">Adición de productos</h2>
            <form method="post" action="http://localhost:8080/crud_products/createProduct">
                <div class="mb-3">
                    <label for="productname" class="form-label">Nombre del producto:</label>
                    <input type="text" class="form-control" name="productname" id="productname" maxlength="50" required>
                    <span id="productname-error" style="color: red;"></span>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock:</label>
                    <input type="text" class="form-control" name="stock" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Precio:</label>
                    <input type="text" class="form-control" name="price" required>
                </div>
                <div class="mb-3">
                    <label for="providerName" class="form-label">Proveedor:</label>
                    <select class="form-select form-control" name="providerName" aria-label="Default select example">
                    <?php
                    foreach ($providers as $provider) {
                        echo '<option value="' . $provider->getId() . '">' . $provider->getRazonSocial() . '</option>';
                    }
                    ?>
                </select>
                </div>
                <div class="mb-3">
                    <label for="stockAlert" class="form-label">Alerta de stock:</label>
                    <input type="text" class="form-control" name="stockAlert" required>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </body>
</html>

<script>
    var existingNames = <?php echo json_encode($nameOfProduct); ?>;
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();

        var product = document.getElementById('productname').value;
        var productError = document.getElementById('productname-error');

        if (existingNames.includes(product)) {
            productError.innerText = 'El producto ya existe.';
        } else {
            this.submit();
        }

    });
</script>