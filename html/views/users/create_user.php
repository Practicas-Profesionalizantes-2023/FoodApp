<?php
include_once "/var/www/html/models/usermodel.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$userModel = new UserModel();

$usuarios = $userModel->getAll();
$genders = $userModel->getAllGender();
$rols = $userModel->getAllRole();

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
        <h2 class="text-center mb-4">Formulario de Registro</h2>
        <form id="miFormulario">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario:</label>
                <input type="text" maxlength="30" class="form-control" name="username" id="username" required>
                <span id="username-error" style="color: red;"></span>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" maxlength="14" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Apellido:</label>
                <input type="text" maxlength="14" class="form-control" name="surname" required>
            </div>
            <div class="mb-3">
                <label for="dni" class="form-label">DNI:</label>
                <input type="text" maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" name="dni" id="dni"required>
                <span id="dni-error" style="color: red;"></span>
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
                <label for="province" class="form-label">Provincia:</label>
                <input type="text" maxlength="20" class="form-control" name="province" required>
            </div>
            <div class="mb-3">
                <label for="localidad" class="form-label">Localidad:</label>
                <input type="text" maxlength="20" class="form-control" name="localidad" required>
            </div>
            <div class="mb-3">
                <label for="street" class="form-label">Calle:</label>
                <input type="text" maxlength="20" class="form-control" name="street" required>
            </div>
            <div class="mb-3">
                <label for="bwStreet" class="form-label">Entre Calle:</label>
                <input type="text" maxlength="20" class="form-control" name="bwStreet" required>
            </div>
            <div class="mb-3">
                <label for="bwStreetTwo" class="form-label">Entre Calle 2:</label>
                <input type="text" maxlength="20" class="form-control" name="bwStreetTwo" required>
            </div>
            <div class="mb-3">
                <label for="altura" class="form-label">Altura:</label>
                <input type="text" maxlength="8" class="form-control" name="altura" required>
            </div>
            <div class="mb-3">
                <label for="cel" class="form-label">Numero de Celular:</label>
                <input type="text" maxlength="20" class="form-control" name="cel" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electronico:</label>
                <input type="email" maxlength="50" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" maxlength="30" class="form-control" name="password" required>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>

    var existingUsernames = <?php echo json_encode($userModel->getAllUsernames()); ?>;
    var existingDnis = <?php echo json_encode($userModel->getAllDni()); ?>;
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();

        var username = document.getElementById('username').value;
        var dni = document.getElementById('dni').value;
        var usernameError = document.getElementById('username-error');
        var dniError = document.getElementById('dni-error');

        if (existingUsernames.includes(username)) {

            usernameError.innerText = 'El nombre de usuario ya podria estar en uso.';
         
            Swal.fire({
                    icon: 'error',
                    title: 'USUARIO YA EXISTE',
                    text: 'Por favor ingrese otro usuario'
                }).then(() => {
          
                });
            

        } else if (existingDnis.includes(dni)) {

            dniError.innerText = 'El dni ya podria estar en uso.';

            Swal.fire({
                    icon: 'error',
                    title: 'DNI YA EXISTE',
                    text: 'Por favor ingrese otro dni'
                }).then(() => {

                });


            } else {



            const formulario = document.getElementById('miFormulario');

            formulario.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(formulario);

            const xhr = new XMLHttpRequest();

            xhr.open('POST', 'http://localhost:8080/crud_users/createUser', true);

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