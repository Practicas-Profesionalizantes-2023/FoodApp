<?php
include_once "/var/www/html/models/productsmodel.php";
$productsModel = new ProductsModel();

$products = $productsModel->getAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Productos</title>
</head>
<body>
    <div class="container">
        <h1 class="mt-6">Productos</h1>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Producto</th>
                    <th>Stock</th>
                    <th>Precio</th>
                    <th>Proveedor</th>
                    <th>Eliminar Producto</th>
                    <th>Editar Producto</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product->getId(); ?></td>
                    <td><?php echo $product->getItemName(); ?></td>
                    <td><?php echo $product->getStock(); ?></td>
                    <td><?php echo $product->getPrice(); ?></td>
                    <td><?php echo $product->getIdProvider(); ?></td>
                    <td>
                        <form id="deleteForm" action='<?php echo constant('URL'); ?>crud_products/deleteProduct' method="POST">
                            <input type="hidden" name="id" value="<?php echo $product->getId(); ?>">
                            <button class="btn btn-danger" type="submit" name="eliminar" onclick="confirmDelete()">Eliminar</button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal" data-id="<?php echo $product->getId(); ?>">Editar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

<script>
function confirmDelete() {
        if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
            document.getElementById("deleteForm").submit();
        } else {
            // El usuario ha cancelado, no hagas nada
        }
    }   
</script>
