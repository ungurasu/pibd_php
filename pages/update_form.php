<div>
    <?php
    $bd = DBConnection::getInstance()::getDB();

    if(isset($_GET['table']) && isset($_GET['pk_name']) && isset($_GET['pk_value'])) {
        $sql_command = sprintf("SELECT * FROM %s WHERE %s = %s;", $_GET['table'], $_GET['pk_name'], $_GET['pk_value']);
        $result = $bd->query($sql_command);

        $data = $result->fetch_assoc();
        ?>

        <h1>Updateaza datele din tabelul <?php printf("%s, unde %s = %s.",$_GET['table'], $_GET['pk_name'], $_GET['pk_value'])?></h1>

        <?php
        $columns_querry = $bd->query(sprintf("SHOW COLUMNS FROM %s;",$_GET['table']));
        ?>
        <form action="/?page=update_action&table=<?= $_GET['table'] ?>&pk_name=<?= $_GET['pk_name'] ?>&pk_value=<?= $_GET['pk_value'] ?>" method="post">
            <?php
            foreach ($columns_querry as $column) {
                if ($column['Key'] != 'PRI') {?>
                    <div class="form-group">
                        <label>Camp: <?php printf("%s",$column["Field"])?></label>
                        <input type="text" class="form-control" id="<?= $column["Field"] ?>" name="<?php printf("%s",$column["Field"])?>" value="<?= $data[$column['Field']] ?>" required>
                        <small class="form-text text-muted">Tip: <?php printf("%s",$column["Type"])?></small>
                    </div>
                    <?php
                }
            }
            ?>
            <button type="submit" class="btn btn-primary">Updateaza</button>
        </form>
    <?php
    }
    ?>
</div>
