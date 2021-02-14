<div>
    <?php
    $bd = DBConnection::getInstance()::getDB();

    // TODO: verificam daca post-ul este gol
    $columns_querry = $bd->query(sprintf("SHOW COLUMNS FROM %s;",$_GET['table']));

    $sql_command = sprintf("INSERT INTO %s (",$_GET['table']);
    foreach($columns_querry as $column) {
        if ($column['Extra'] != 'auto_increment') {
            $sql_command .= "{$column['Field']}, ";
        }
    }
    $sql_command = substr($sql_command,0,-2);
    $sql_command .= ') VALUES (';
    foreach($columns_querry as $column) {
        if ($column['Extra'] != 'auto_increment') {
            $sql_command .= "'{$_POST[$column['Field']]}', ";
        }
    }
    $sql_command = substr($sql_command,0,-2);
    $sql_command .= ');';

    if ($bd->query($sql_command) === TRUE) {
        $_SESSION['message'] = [
            'heading' => 'Am inserat cu succes!',
            'message' => 'Vei fi redirectionat in 5 secunde la homescreen.',
            'message_color' => 'success'
        ];
    } else {
        $_SESSION['message'] = [
            'heading' => 'Eroare la inserare!',
            'message' => 'Nu am putut insera in baza de date: ' . $bd->error . '\nQuery: ' . $sql_command,
            'message_color' => 'danger'
        ];
    }

    ?>
    <meta http-equiv="refresh" content="0; url=/" />
</div>
