<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/styleLogin.css">
    <title>Login</title>
</head>
<body>
    <form action="<?php echo constant('URL'); ?>login/authenticate" method="post">
    <div><?php (isset($this->errorMessage))?  $this->errorMessage : ''?></div>
    <h1>Inicio de sesión</h1>

    <label for="username">Username</label>
    <input type="text" name="username" id="username">

    <label for="password">Password</label>
    <input type="password" name="password" id="password">

    <input type= "submit" class="btn-1" value="Iniciar">
    <p><?php 
        $this->showMessages();
    ?></p>
    </form>

</body>
</html>