<div>
    <?php
    $bd = DBConnection::getInstance()::getDB();
    $sql_command = sprintf("DELETE FROM %s WHERE %s = %s;", $_GET['table'], $_GET['pk_name'],$_GET['pk_value']);
    //printf("%s", $sql_command);

    //TODO: verificam daca get-ul e gol
    if ($bd->query($sql_command) === TRUE) {
        $_SESSION['message'] = [
            'heading' => 'Succes!',
            'message' => 'Delete efectuat',
            'message_color' => 'success'
        ];
    } else {
        $_SESSION['message'] = [
            'heading' => 'Eroare la stergerea datelor!',
            'message' => 'Nu am putut sterge din baza de date: ' . $bd->error . '\nQuery: ' . $sql_command,
            'message_color' => 'danger'
        ];
    }

    ?>
    <meta http-equiv="refresh" content="0; url=/" />
</div>
