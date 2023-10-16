<?php
include_once "/var/www/html/models/menumodel.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$menuModel = new MenuModel();

$menus = $menuModel->getAll();
$categorys = $menuModel->getAllCat();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Menu</title>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Formulario de Menu</h2>
        <form id="miFormulario">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre de Menu:</label>
                <input type="text" maxlength="30" class="form-control" name="name" id="name" required>
                <span id="name-error" style="color: red;"></span>
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Detalle del Menu:</label>
                <input type="text" maxlength="50" class="form-control" name="detail" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Precio:</label>
                <input type="text" maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" name="price" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Categoria:</label>
                <select class="form-select form-control" name="category" aria-label="Default select example">
                    <?php
                        foreach ($categorys as $cat) {
                            echo '<option value="' . $cat->getIdCat() . '">' . $cat->getCatName() . '</option>';
                        }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>

    var existingNames = <?php echo json_encode($menuModel->getAllnames()); ?>;
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();

        var name = document.getElementById('name').value;
        var nameError = document.getElementById('name-error');

        if (existingNames.includes(name)) {

            nameError.innerText = 'El nombre del menu ya está en uso.';
         
            Swal.fire({
                    icon: 'error',
                    title: 'MENU YA EXISTE',
                    text: 'Por favor ingrese otro menu'
                }).then(() => {
          
                });
            

        } else {


            const formulario = document.getElementById('miFormulario');

            formulario.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(formulario);

            const xhr = new XMLHttpRequest();

            xhr.open('POST', 'http://localhost:8080/crud_menus/createMenu', true);

            xhr.onload = function () {
                if (xhr.status === 200) {

                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Formulario enviado con éxito'
                }).then(() => {
                    formulario.reset();
                });
                } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al enviar el formulario',
                });
                }
            };

            xhr.send(formData);
            });

        }
    });
</script>