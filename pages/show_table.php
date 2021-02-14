<div class="py-5">
    <?php
        $bd = DBConnection::getInstance()::getDB();
    ?>

    <?php if(!isset($_GET['table'])) { ?>
        <h1>Vezi tabel</h1>
        <div class="alert alert-warning">Nu ai ales niciun tabel :(</div>

        <?php

        $result = $bd->query("SHOW TABLES;");
        if(!$result)
            throw new Exception("N-a mers query-ul: " . $bd->error);

        $tables = [];
        foreach ($result as $row) {
            $key = array_keys($row);
            $tables[] = $row[$key[0]];
        }
        ?>

        <div class="row">
            <div class="col-6">
                <form action="/" method="get">
                    <input type="hidden" name="page" value="show_table" />

                    <div class="form-group">
                        <label for="tableName">Denumire tabel</label>
                        <select id="tableName" class="form-control" name="table">
                            <option disabled selected>Alege un tabel...</option>
                            <?php foreach($tables as $table) { ?>
                                <option value="<?= htmlentities($table) ?>"><?= htmlentities($table) ?></option>
                            <?php } ?>
                        </select>
                        <small class="form-text text-muted">Alege un tabel din baza de date.</small>
                    </div>

                    <button type="submit" class="btn btn-success">Du-te</button>
                </form>
            </div>
        </div>


    <?php } else {

    $requested_table = $bd->real_escape_string($_GET['table']);
    $columns_query = $bd->query("SHOW COLUMNS FROM $requested_table;");
    $pk_name = "";
    foreach ($columns_query as $column) {
        $columns[] = $column["Field"];
        if ($column['Key'] == 'PRI') {
            $pk_name = $column["Field"];
        }
        //var_dump($column);
    }
    //var_dump($pk_name);

    $referenced_tables = [];
    $inner_joins = [];
    $constrained = false;
    $sql_command = "";
    foreach ($columns as $column) {
        //var_dump($column);
        $sql_command = sprintf("SELECT REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME, TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = '%s' AND TABLE_NAME = '%s' AND COLUMN_NAME = '%s';",$_SESSION['db_database'],$requested_table,$column);
        //printf($sql_command);
        $referenced_tables_queries = $bd->query($sql_command);
        foreach($referenced_tables_queries as $referenced_table_queried) {
            //var_dump($referenced_table_queried);
            $referenced_tables[$referenced_table_queried["REFERENCED_TABLE_NAME"]] = $referenced_table_queried["REFERENCED_TABLE_NAME"];
            $constrained = true;
            $inner_joins[] = sprintf("INNER JOIN %s ON %s.%s = %s.%s ",$referenced_table_queried["REFERENCED_TABLE_NAME"],$referenced_table_queried["TABLE_NAME"],$referenced_table_queried["COLUMN_NAME"],$referenced_table_queried["REFERENCED_TABLE_NAME"],$referenced_table_queried["REFERENCED_COLUMN_NAME"]);
        }
    }

    //var_dump($referenced_tables);
    //var_dump($inner_joins);
    $sql_command = substr("SELECT ",0);
    foreach ($referenced_tables as $referenced_table){
        $columns_query = $bd->query("SHOW COLUMNS FROM $referenced_table;");
        foreach ($columns_query as $column) {
            $sql_command .= $referenced_table;
            $sql_command .= '.';
            $sql_command .= $column["Field"];
            $sql_command .= ', ';
        }
    }
    $columns_query = $bd->query("SHOW COLUMNS FROM $requested_table;");
    foreach ($columns_query as $column) {
        $sql_command .= $requested_table;
        $sql_command .= '.';
        $sql_command .= $column["Field"];
        $sql_command .= ', ';
    }
    $sql_command = substr($sql_command,0,-2);
    $sql_command .= " FROM $requested_table ";
    if ($constrained) {
        foreach ($inner_joins as $inner_join) {
            $sql_command .= $inner_join;
        }
    }
    //var_dump($sql_command);
    $result = $bd->query($sql_command);

    if(!$result)
        throw new Exception("N-a mers query-ul: " . $bd->error);

    $fields = $result->fetch_fields();

    ?>

        <h1>Tabelul '<?= $requested_table ?>'</h1>
        <p class="lead">Se afiseaza <?= $result->num_rows ?> randuri.</p>
        <div class="row justify-content-center col-auto">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <?php foreach ($fields as $field) { ?>
                            <th><?= htmlentities($field->name) ?></th>
                        <?php } ?>
                        <th>Delete</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result as $row) { ?>
                        <tr>
                            <?php foreach ($fields as $field) { ?>
                                <td><?= htmlentities($row[$field->name]) ?></td>
                            <?php } ?>
                            <td><a class="btn btn-danger" href="?page=delete_action<?php printf("&table=%s&pk_name=%s&pk_value=%s",$_GET['table'],$pk_name,$row[$pk_name])?>">Delete</a></td>
                            <td><a class="btn btn-primary" href="?page=update_form<?php printf("&table=%s&pk_name=%s&pk_value=%s",$_GET['table'],$pk_name,$row[$pk_name])?>">Update</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    <?php } ?>
</div>
