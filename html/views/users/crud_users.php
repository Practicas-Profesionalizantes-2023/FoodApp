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

usort($usuarios, "cmp");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Empleados</title>
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
                    console.log(xhr.responseText);
                    var row = document.getElementById("userRow" + userId);
                    if (row) {
                        row.remove();
                    }
                    CargarContenido('views/users/crud_users.php', 'content-wrapper');
                } else {
                    console.error('Error en la solicitud: ' + xhr.status);
                }
            };
            xhr.send("id=" + userId);
        }
    });
}

</script>

<script>

        $(document).ready(function() {
            $(".btn-edit").click(function() {
                var userId = $(this).data("id");

                $.ajax({
                    url: "views/users/edit_users.php",
                    type: "GET",
                    data: { id: userId },
                    success: function(response) {
                        $("#edit-form-container").html(response).slideDown();
                        event.preventDefault();
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
