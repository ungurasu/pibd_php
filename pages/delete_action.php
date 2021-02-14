<div class="py-5">
    <?php
    $bd = DBConnection::getInstance()::getDB();
    $sql_command = sprintf("DELETE FROM %s WHERE %s = %s;", $_GET['table'], $_GET['pk_name'],$_GET['pk_value']);
    //printf("%s", $sql_command);

    //TODO: verificam daca get-ul e gol
    if ($bd->query($sql_command) === TRUE) { ?>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Am sters cu succes!</h4>
            <p>Vei fi redirectionat in 5 secunde la homescreen.</p>
        </div>
        <meta http-equiv="refresh" content="5; url=/" />
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
