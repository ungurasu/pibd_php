<div class="py-5">
    <?php
    $bd = DBConnection::getInstance()::getDB();
    $sql_command = sprintf("DELETE FROM %s WHERE %s = %s;", $_GET['table'], $_GET['pk_name'],$_GET['pk_value']);
    //printf("%s", $sql_command);

    //TODO: redirectionare
    if ($bd->query($sql_command) === TRUE) { ?>
        <div class="alert alert-success" role="alert">
            Am sters cu succes!
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
