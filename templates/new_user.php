
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear un nou usuari</title>
</head>
<body>
    <?php
        
        if (!empty($_POST['insertar'])) {
            $errors = array();   

            (empty($_POST['nom'])) ? $errors['nom_missing'] = true : $nom = $_POST['nom'];
            (empty($_POST['dni'])) ? $errors['dni_missing'] = true : $dni = $_POST['dni'];

            (empty($_POST['email'])) ? $errors['email_missing'] = true : "";
            
            (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
                ? $errors['email_invalid'] = true 
                : $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        }
    ?>

    <h1>Nou usuari</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="nom">Introdueix un nom: </label>
        <input type="text" id="nom" name="nom" placeholder="Introdueix un nom" value="<?php echo (isset($nom)) ? htmlspecialchars(stripslashes(trim($nom))) : ""; ?>"><br>
        <label for="dni">Introdueix el teu DNI: </label>
        <input type="text" id="dni" name="dni" placeholder="Introdueix un DNI" value="<?php echo (isset($dni)) ? htmlspecialchars(stripslashes(trim($dni))) : ""; ?>"><br>
        <label for="email">Introdueix la teva adreça electrònica: </label>
        <input type="text" id="email" name="email" placeholder="Introdueix la adreça electrònica" value="<?php echo (isset($email)) ? htmlspecialchars(stripslashes(trim($email))) : ""; ?>"><br>
        <input type="submit" name="insertar" value="Crear">
        <?php
            if (isset($success)) {
                
            } 
            if (isset($failure)) {
                
            }
        ?>
    </form>
</body>
</html>

<?php

    if (!empty($_POST['insertar']) && empty($errors)) {

        include "../modules/config/environment.php";
        $url = ENVIRONMENT->protocol . ENVIRONMENT->baseUrl . ENVIRONMENT->dir->modules->api->create;
        
        $data = array('nom' => $nom, 'dni' => $dni, 'adresa' => $email);

        // Construïm la petició a /modules/api/ (què és el que seria l'entrada al Backend)
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = json_decode(file_get_contents($url, false, $context));

        if (!empty($result->success)) { print '<small style=\'color:green\'>' . $result->success . '</small>';}
        if (!empty($result->error)) { print '<small style=\'color:red\'>' . $result->error . '</small>'; }
        
    }
?>