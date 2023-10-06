<?php
include_once "/var/www/html/models/usermodel.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$userModel = new UserModel();

$usuarios = $userModel->getAll();

// Define una función de comparación para ordenar los usuarios por ID
function cmp($a, $b) {
    return $a->getId() - $b->getId();
}

// Ordena el array de usuarios usando la función de comparación
usort($usuarios, "cmp");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Empleados</title>
</head>
<body>
<div class="container">
        <h1 class="mt-6">Empleados</h1>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Eliminar Usuario</th>
                    <th>Editar Usuario</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <?php if ($usuario->getDeleted() == 1): ?>
                <tr>
                    <td><?php echo $usuario->getId(); ?></td>
                    <td><?php echo $usuario->getUsername(); ?></td>
                    <td><?php echo $usuario->getName(); ?></td>
                    <td><?php echo $usuario->getSurname(); ?></td>
                    <td><?php echo $usuario->getRoleName(); ?></td>
                    <td><?php echo $usuario->getState(); ?></td>
                    <td>
                        <form id="deleteForm<?php echo $usuario->getId(); ?>" action='<?php echo constant('URL'); ?>crud_users/deleteUser' method="POST">
                            <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>">
                            <button id="eliminarBtn" class="btn btn-danger" type="button" name="eliminar" onclick="confirmDelete('<?php echo $usuario->getId(); ?>')">Eliminar</button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal" data-id="<?php echo $usuario->getId(); ?>">Editar</button>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
    </table>
    </div>
    <div id="edit-form-container" style="display: none;"></div>
    <!-- Script para cargar el formulario de edición -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function confirmDelete(userId) {
            if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
                document.getElementById("deleteForm" + userId).submit();
            } else {
                // El usuario ha cancelado, no hagas nada
            }
        }

        $(document).ready(function() {
            // Maneja el clic en el botón "Editar"
            $(".btn-edit").click(function() {
                var userId = $(this).data("id");

                // Realiza una solicitud AJAX para obtener el formulario de edición
                $.ajax({
                    url: "views/users/edit_users.php", // Ruta al archivo de edición de usuario
                    type: "GET",
                    data: { id: userId }, // Envía el ID del usuario
                    success: function(response) {
                        // Muestra el formulario de edición en el contenedor
                        $("#edit-form-container").html(response).slideDown();
                    },
                    error: function() {
                        alert("Error al cargar el formulario de edición.");
                    }
                });
            });
        });
    </script>
</body>
</html>
