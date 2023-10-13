<?php
include_once "/var/www/html/models/providermodel.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$providerModel = new ProviderModel();
$providers = $providerModel->getAll();

$razonesSociales = array();
foreach ($providers as $provider) {
    $razonesSociales[] = $provider->getRazonSocial();
}
$CUIT = array();
foreach ($providers as $provider) {
    $CUIT[] = $provider->getCuit();
}
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
            <h2 class="text-center mb-4">Registro de Proveedor</h2>
            <form method="post" action="http://localhost:8080/crud_providers/createProvider">
                <div class="mb-3">
                    <label for="providerName" class="form-label">Razón social:</label>
                    <input type="text" maxlength="20" class="form-control" name="providerName" id="providerName" required>
                    <span id="providerName-error" style="color: red;"></span>
                </div>
                <div class="mb-3">
                    <label for="CUIT" class="form-label">CUIT:</label>
                    <input type="text" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" name="CUIT" id="CUIT" required>
                    <span id="CUIT-error" style="color: red;"></span>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </body>
</html>

<script>
    var existingNames = <?php echo json_encode($razonesSociales); ?>;
    var existingCuit = <?php echo json_encode($CUIT); ?>;
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();

        var provider = document.getElementById('providerName').value;
        var providerError = document.getElementById('providerName-error');
        var cuit = document.getElementById('CUIT').value;
        var cuitError = document.getElementById('CUIT-error');

        if (existingNames.includes(provider)) {
            providerError.innerText = 'El proveedor ya está registrado.';
        } else if(existingCuit.includes(cuit)){
            cuitError.innerText = 'El CUIT ya está registrado';
        } else{
            this.submit();
        }

    });
</script>