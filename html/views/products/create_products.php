<?php
include_once "/var/www/html/models/productsmodel.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$productsModel = new ProductsModel();

$products = $productsModel->getAll();
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
            <h2 class="text-center mb-4">Formulario de Adición</h2>
            <form method="post" action="http://localhost:8080/crud_products/createProduct">
                <div class="mb-3">
                    <label for="username" class="form-label">Nombre del producto:</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                    <span id="username-error" style="color: red;"></span>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Stock:</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="surname" class="form-label">Precio:</label>
                    <input type="text" class="form-control" name="surname" required>
                </div>
                <div class="mb-3">
                    <label for="dni" class="form-label">DNI:</label>
                    <input type="text" class="form-control" name="dni" required>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Genero:</label>
                    <select class="form-select form-control" name="gender" aria-label="Default select example">
                        <?php
                        foreach ($genders as $gender) {
                            echo '<option value="' . $gender->getGender() . '">' . $gender->getGenderName() . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="state" class="form-label">Estado:</label>
                    <input type="text" class="form-control" name="state" required>
                </div>
                <div class="mb-3">
                    <label for="rol" class="form-label">Rol:</label>
                    <select class="form-select form-control" name="rol" aria-label="Default select example">
                        <?php
                        foreach ($rols as $rol) {
                            echo '<option value="' . $rol->getRole() . '">' . $rol->getRoleName() . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </body>
</html>