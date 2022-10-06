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
    <title>Crear un nou usuari</title>
</head>
<body>
    <?php
    //Treballem les dades que ens arriben de l'usuari original
        include "validators.php";
        
        if (empty($_POST)) {
            $nom_original = $usuari->nom;
            $dni_original = $usuari->dni;
            $email_original = $usuari->adresa;
        }

        // Form data validation
        if (!empty($_POST['update'])) {
            $errors = array(); 

            if(empty($_POST['nom'])) {
                $errors['nom_missing'] = true;
            } else {
                $nom = $_POST['nom'];
            }

            if (!empty($_POST['dni'])) {
                $dni = $_POST['dni'];
            }

            if(empty($_POST['email'])){
                $errors['email_missing'] = true;
            } else {
                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    $errors['email_invalid'] = true;
                } else {
                    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                }
            }

        } else {
            $nom = $nom_original;
            $dni = $dni_original;
            $email = $email_original;
        }
    ?>
    <!-- FORMULARI -->
    <h1>Nou usuari</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

        <label for="nom">Introdueix un nom: </label>
        <input type="text" id="nom" name="nom" placeholder="Introdueix un nom" 
            value="<?php echo (isset($nom)) ? htmlspecialchars(stripslashes(trim($nom))) : ""; ?>">

        <?php if (!empty($errors['nom_missing'])) : ?>
            <small style="color:red">El camp nom és obligatori.</small>
        <?php endif; ?><br>

        <label for="dni">Introdueix el DNI: </label>
        <input type="text" id="dni" name="dni" placeholder="Introdueix un DNI" 
            value="<?php echo (isset($dni)) ? htmlspecialchars(stripslashes(trim($dni))) : ""; ?>" readonly><br>

        <label for="email">Introdueix la teva adreça electrònica: </label>
        <input type="text" id="email" name="email" placeholder="Introdueix la adreça electrònica" 
            value="<?php echo (isset($email)) ? htmlspecialchars(stripslashes(trim($email))) : ""; ?>">

        <?php if (!empty($errors['email_missing'])) : ?>
            <small style="color:red">Aquest camp és obligatori.</small>
        <?php endif; ?>
        <?php if (!empty($errors['email_invalid'])) : ?>
            <small style="color:red">Adreça invàlida.</small>
        <?php endif; ?><br>

        <input type="submit" name="update" value="Modificar">
    </form>
    <form action="../index.php">
        <input type="submit" name="tornar" value="Tornar">
    </form>
</body>
</html>

<?php

    // Construïm la petició a /modules/api/ (què és el que seria l'entrada al Backend) per modificar l'usuari
    if (!empty($_POST['update']) && empty($errors)) {

        $env = json_decode(file_get_contents("../environment/environment.json"));

        $environment = $env->environment;

        $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->update;
        
        $data = array('nom' => $nom, 'dni' => $dni, 'adresa' => $email);

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = json_decode(file_get_contents($url, false, $context));

        

        if($result !== null) {
            ($result->updated) 
            ? print '<small style=\'color:green\'>' . $result->message . '</small>' 
            : print '<small style=\'color:red\'>' . $result->message . '</small>';
        }        
    }
?>