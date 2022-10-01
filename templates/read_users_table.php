<table>
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>DNI</th>
            <th>Email</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
<?php   foreach ($llista_usuaris as $index=>$usuari) { ?>
        <tr>
            <td><?php echo htmlspecialchars(stripslashes(trim($index+1))) ?></td>
            <td><?php echo htmlspecialchars(stripslashes(trim($usuari->getNom()))) ?></td>
            <td><?php echo htmlspecialchars(stripslashes(trim($usuari->getDni()))) ?></td>
            <td><?php echo htmlspecialchars(stripslashes(trim($usuari->getEmail()))) ?></td>
            <td>
                <form action="update_user.php" method="POST">
                    <input type="submit" name="<?php echo htmlspecialchars(stripslashes(trim($usuari->getDni()))) ?>" value="Modificar">
                </form>
            </td>
            <td>
                <form action="delete_user.php" method="POST">
                    <input type="submit" name="<?php echo htmlspecialchars(stripslashes(trim($usuari->getDni()))) ?>" value="Eliminar">
                </form>
            </td>
        </tr>
<?php } ?>

</table>