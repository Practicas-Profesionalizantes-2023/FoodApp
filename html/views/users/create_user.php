<?php
include_once "/var/www/html/models/usermodel.php";
// Asegúrate de que la ruta sea correcta
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
    <!-- Enlaces a los archivos CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Formulario de Registro</h2>
        <form method="post" action="http://localhost:8080/crud_users/createUser">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario:</label>
                <input type="text" class="form-control" name="username" id="username" required>
                <span id="username-error" style="color: red;"></span>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Apellido:</label>
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
                <label for="province" class="form-label">Provincia:</label>
                <input type="text" class="form-control" name="province" required>
            </div>
            <div class="mb-3">
                <label for="localidad" class="form-label">Localidad:</label>
                <input type="text" class="form-control" name="localidad" required>
            </div>
            <div class="mb-3">
                <label for="street" class="form-label">Calle:</label>
                <input type="text" class="form-control" name="street" required>
            </div>
            <div class="mb-3">
                <label for="bwStreet" class="form-label">Entre Calle:</label>
                <input type="text" class="form-control" name="bwStreet" required>
            </div>
            <div class="mb-3">
                <label for="bwStreetTwo" class="form-label">Entre Calle 2:</label>
                <input type="text" class="form-control" name="bwStreetTwo" required>
            </div>
            <div class="mb-3">
                <label for="altura" class="form-label">Altura:</label>
                <input type="text" class="form-control" name="altura" required>
            </div>
            <div class="mb-3">
                <label for="cel" class="form-label">Numero de Celular:</label>
                <input type="text" class="form-control" name="cel" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electronico:</label>
                <input type="text" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">Estado:</label>
                <input type="text" class="form-control" name="state" required>
            </div>
            <div class="mb-3">
                <label for="deleted" class="form-label">Desabilitado:</label>
                <input type="text" class="form-control" name="deleted" required>
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

    <!-- Scripts de Bootstrap (opcional, solo si necesitas funcionalidades de JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>
    var existingUsernames = <?php echo json_encode($userModel->getAllUsernames()); ?>;
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();

        var username = document.getElementById('username').value;
        var usernameError = document.getElementById('username-error');

        if (existingUsernames.includes(username)) {
            usernameError.innerText = 'El nombre de usuario ya está en uso.';
        } else {
            // Envía el formulario si el nombre de usuario no está en uso
            this.submit();
        }
    });
</script>
