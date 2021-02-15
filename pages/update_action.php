<div>
    <?php
    $bd = DBConnection::getInstance()::getDB();


    //TODO: verificam daca post-ul este gol
    $columns_querry = $bd->query(sprintf("SHOW COLUMNS FROM %s;",$_GET['table']));

    $sql_command = sprintf("UPDATE %s SET ",$_GET['table']);
    foreach($columns_querry as $column) {
        if ($column['Extra'] != 'auto_increment') {
            $sql_command .= sprintf("%s='%s', ", $column['Field'], $_POST[$column['Field']]);
        }
    }
    $sql_command = substr($sql_command,0,-2);
    $sql_command .= sprintf(" WHERE %s=%s;", $_GET['pk_name'], $_GET['pk_value']);

    //printf("%s",$sql_command);
    //var_dump($_GET);
    //var_dump($_POST);
    if ($bd->query($sql_command) === TRUE) {
        $_SESSION['message'] = [
            'heading' => 'Succes!',
            'message' => 'Update efectuat.',
            'message_color' => 'success'
        ];
    } else {
        $_SESSION['message'] = [
            'heading' => 'Eroare la update!',
            'message' => 'Nu am putut realiza update-ul: ' . $bd->error . '\nQuery: ' . $sql_command,
            'message_color' => 'danger'
        ];
    }

    ?>
    <meta http-equiv="refresh" content="0; url=/" />
</div>
