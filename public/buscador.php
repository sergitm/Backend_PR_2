    <!--
    /**
     * @author Sergi Triadó <s.triado@sapalomera.cat>
     */
    -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador d'usuaris</title>
</head>
<body>
    <!-- Aquest input serveix per filtrar la llista d'usuaris -->
    <form name="read_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
        <input type="text" name="buscador" placeholder="Busca un usuari"> 
        <input type="submit" name="buscar" value="Buscar">
    </form>
</body>
</html>