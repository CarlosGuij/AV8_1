<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importación</title>
</head>
<body>
    <h1>Importación de Marcas</h1>

    <?php
    require_once 'marcas.php';

    $gestion = new Gestion();
    echo $gestion->getBrands();
    ?>

    <h2>Importación de Clientes</h2>

    <?php
    require_once 'clases/Importar.php';

    $importar = new Importar();
    $importar->customers();
    echo "<p>¡Clientes importados con éxito!</p>";
    ?>

</body>
</html>
