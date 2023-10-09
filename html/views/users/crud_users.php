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
        <!-- En la cabecera del HTML de la página donde está el botón para abrir el modal -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="views/users/edit_users.php"></script>
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
<!-- Script para cargar el formulario de edición -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div id="edit-form-container" style="display: none;"></div>
<script>
function confirmDelete(userId) {
    Swal.fire({
        title: '¿Estás seguro de que deseas eliminar este usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "http://localhost:8080/crud_users/deleteUser", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // La solicitud se completó con éxito, maneja la respuesta aquí si es necesario
                    console.log(xhr.responseText);
                    // Eliminar la fila correspondiente en la interfaz de usuario
                    var row = document.getElementById("userRow" + userId);
                    if (row) {
                        row.remove();
                    }
                    // Recargar el contenido del contenedor después de eliminar el usuario
                    CargarContenido('views/users/crud_users.php', 'content-wrapper');
                } else {
                    // Ocurrió un error durante la solicitud
                    console.error('Error en la solicitud: ' + xhr.status);
                }
            };
            // Enviar la solicitud con el ID del usuario a eliminar
            xhr.send("id=" + userId);
        }
    });
}

</script>

<script>

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
