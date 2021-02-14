<div class="py-5">
    <?php
    $bd = DBConnection::getInstance()::getDB();

    if(isset($_GET['table']) && isset($_GET['pk_name']) && isset($_GET['pk_value'])) {
        $sql_command = sprintf("SELECT * FROM %s WHERE %s = %s;", $_GET['table'], $_GET['pk_name'], $_GET['pk_value']);
        $data = $bd->query($sql_command);

        $rows = [];
        foreach ($data as $row) {
            $rows[] =$row;
        }
        //var_dump($rows[0]);
        ?>

        <h1>Updateaza datele din tabelul <?php printf("%s, unde %s = %s.",$_GET['table'], $_GET['pk_name'], $_GET['pk_value'])?></h1>

        <?php
        $columns_querry = $bd->query(sprintf("SHOW COLUMNS FROM %s;",$_GET['table']));
        ?>
        <form action="/?page=update_action<?php printf("&table=%s&pk_name=%s&pk_value=%s",$_GET['table'],$_GET['pk_name'],$_GET['pk_value'])?>" method="post">
            <?php
            foreach ($columns_querry as $column) {
                if ($column['Key'] != 'PRI') {?>
                    <div class="form-group">
                        <label>Camp: <?php printf("%s",$column["Field"])?></label>
                        <input type="text" class="form-control" id="<?php printf("%s",$column["Field"])?>" name="<?php printf("%s",$column["Field"])?>" value="<?php printf("%s",$rows[0][$column['Field']])?>" required>
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
