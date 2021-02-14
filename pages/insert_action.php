<div class="py-5">
    <?php
    $bd = DBConnection::getInstance()::getDB();
    ?>

    <?php
    // TODO: verificam daca post-ul este gol
    $columns_querry = $bd->query(sprintf("SHOW COLUMNS FROM %s;",$_GET['table']));

    $sql_command = sprintf("INSERT INTO %s (",$_GET['table']);
    foreach($columns_querry as $column) {
        if ($column['Extra'] != 'auto_increment') {
            $sql_command .= sprintf("%s, ", $column['Field']);
        }
    }
    $sql_command = substr($sql_command,0,-2);
    $sql_command .= ') VALUES (';
    foreach($columns_querry as $column) {
        if ($column['Extra'] != 'auto_increment') {
            $sql_command .= sprintf("'%s', ", $_POST[$column['Field']]);
        }
    }
    $sql_command = substr($sql_command,0,-2);
    $sql_command .= ');';

    if ($bd->query($sql_command) === TRUE) { ?>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Am inserat cu succes!</h4>
            <p>Vei fi redirectionat in 5 secunde la homescreen.</p>
        </div>
        <meta http-equiv="refresh" content="5; url=/" />
    <?php } else { ?>
        <div class="alert alert-danger" role="alert">
            <?php printf("%s", $bd->error)?>
        </div>
    <?php
    }
    ?>
</div>
