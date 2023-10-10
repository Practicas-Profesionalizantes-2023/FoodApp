<?php
include_once "/var/www/html/models/usermodel.php";
class Crud_users extends SessionController {
    function __construct(){
        parent::__construct();
        error_log('DASHBOARD-> inicio de dashboard');

    }

    function render(){
        error_log('DASHBOARD-> CARGA EL INDEX DASHBOARD');
        $this->view->render('users/crud_users');
    }


    public function deleteUser(){
        if($this->existPOST(['id'])){
            $deleted = 0;
            $idUsuarioAEliminar = $this->getPOST('id');
            error_log('dolete--> id: '. $idUsuarioAEliminar);
            $userModel = new UserModel();

        // Intenta eliminar el usuario con la función delete
        if ($userModel->delete($idUsuarioAEliminar, $deleted)) {
            echo "Usuario eliminado exitosamente.";
        } else {
            echo "Error al eliminar el usuario.";
            error_log("Error al eliminar el usuario con ID " . $idUsuarioAEliminar);
        }
            
        }
    }


    public function editUser(){
        if($this->existPOST(['id', 'nombre', 'name', 'surname','dni', 'gender', 'province', 'localidad', 'street',
        'bwStreet','bwStreetTwo', 'altura', 'cel','password', 'email', 'rol', 'state'])){
            $id = $_POST["id"];
            error_log($id);
            $username = $_POST["nombre"];
            error_log($username);
            $dni = $_POST["dni"];
            error_log($dni);
            // Verificar si el nuevo nombre de usuario ya existe en la base de datos
            $userModel = new UserModel();
            if ($userModel->usernameExists($id, $username,$dni)) {
                echo "El nombre de usuario ya está en uso. Por favor, elige otro nombre de usuario.";
                error_log("El nombre de usuario ya esta en uso");
            } else {
                // Resto de tus variables
                $name = $_POST["name"];
                error_log($name);
                $surname = $_POST["surname"];
                error_log($surname);
                $gender = $_POST["gender"];
                $province = $_POST["province"];
                $localidad = $_POST["localidad"];
                $street = $_POST["street"];
                $bwStreet = $_POST["bwStreet"];
                $bwStreetTwo = $_POST["bwStreetTwo"];
                $altura = $_POST["altura"];
                $cel = $_POST["cel"];
                $password = $_POST["password"];
                $email = $_POST["email"];
                $rol = $_POST["rol"];
                $state = $_POST["state"];

            $userModel = new UserModel();
    if ($userModel->update($id, $username, $name, $surname, $dni, $gender, $province, $localidad, $street, 
    $bwStreet, $bwStreetTwo, $altura, $cel, $password ,$email, $rol, $state)) {
        echo "Usuario actualizado exitosamente.";
    } else {
        echo "Error al actualizar el usuario.";
    }
}
}
}
    public function createUser(){
        if($this->existPOST(['username', 'name', 'surname','dni', 'gender', 'province', 'localidad', 'street',
        'bwStreet','bwStreetTwo', 'altura', 'cel', 'email', 'rol','password'])){
            $username = $_POST["username"];
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $dni = $_POST["dni"];
            $gender = $_POST["gender"];
            $province = $_POST["province"];
            $localidad = $_POST["localidad"];
            $street = $_POST["street"];
            $bwStreet = $_POST["bwStreet"];
            $bwStreetTwo = $_POST["bwStreetTwo"];
            $altura = $_POST["altura"];
            $cel = $_POST["cel"];
            $email = $_POST["email"];
            $rol = $_POST["rol"];
            $password = $_POST["password"];

            $userModel = new UserModel();
            if ($userModel->createUser($username, $name, $surname, $dni, $gender, $province, $localidad, $street, 
            $bwStreet, $bwStreetTwo, $altura, $cel, $email, $rol, $password)) {
                echo "Usuario creado exitosamente.";
            } else {
                echo "Error al crear el usuario.";
            }

        }
    }


}

?>