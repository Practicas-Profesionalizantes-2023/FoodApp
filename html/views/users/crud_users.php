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
                    <th>Desabilitar Usuario</th>
                    <th>Editar Usuario</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario->getId(); ?></td>
                    <td><?php echo $usuario->getUsername(); ?></td>
                    <td><?php echo $usuario->getName(); ?></td>
                    <td><?php echo $usuario->getSurname(); ?></td>
                    <td><?php echo $usuario->getRoleName(); ?></td>
                    <td>
                    <?php
                    if ($usuario->getDeleted() > 0) {
                        echo '<form id="deleteForm' . $usuario->getId() . '" action="' . constant('URL') . 'crud_users/deleteUser" method="POST">';
                        echo '<input type="hidden" name="id" value="' . $usuario->getId() . '">';
                        echo '<button id="eliminarBtn" class="btn btn-danger" type="button" name="eliminar" onclick="confirmDelete(\'' . $usuario->getId() . '\')">Desabilitar</button>';
                        echo '</form>';
                    } else {
                        echo '<form id="enabledForm' . $usuario->getId() . '" action="' . constant('URL') . 'crud_users/enabledUser" method="POST">';
                        echo '<input type="hidden" name="id" value="' . $usuario->getId() . '">';
                        echo '<button id="enabledBtn" class="btn btn-success" type="button" name="habilitar" onclick="confirmEnabled(\'' . $usuario->getId() . '\')">&nbsp;&nbsp;Habilitar&nbsp;&nbsp;</button>';
                        echo '</form>';                    }
                    ?>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-edit" onclick="openEditModal(<?php echo $usuario->getId(); ?>)">Editar</button>
                    </td>
                </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div id="edit-form-container" style="display: none;"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
            xhr.open("POST", "<?php echo constant('URL') ?>crud_users/deleteUser", true);
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
function confirmEnabled(userId) {
    Swal.fire({
        title: '¿Estás seguro de que deseas habilitar este usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, habilitar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?php echo constant('URL') ?>crud_users/enabledUser", true);
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

    function openEditModal(userId) {
        // Realiza una solicitud AJAX para obtener el formulario de edición
        $.ajax({
            url: "views/users/edit_users.php", // Ruta al archivo de edición de usuario
            type: "GET",
            data: { id: userId }, // Envía el ID del usuario
            success: function(response) {
                // Muestra el formulario de edición en el contenedor
                $("#edit-form-container").html(response).slideDown();
                // Abre el modal
                $("#editarUsuarioModal").modal("show");
            },
            error: function() {
                alert("Error al cargar el formulario de edición.");
            }
        });
    }

</script>
</body>
</html>
