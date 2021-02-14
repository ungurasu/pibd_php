<div class="py-5">
    <?php
    $bd = DBConnection::getInstance()::getDB();


    //TODO: verificam daca post-ul este gol
    //TODO: redirectionare
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
    if ($bd->query($sql_command) === TRUE) { ?>
        <div class="alert alert-success" role="alert">
            Am updatat cu succes!
        </div>
        <?php
    }
    else { ?>
        <div class="alert alert-danger" role="alert">
            <?php printf("%s", $bd->error)?>
        </div>
        <?php
    }
    ?>
</div>
