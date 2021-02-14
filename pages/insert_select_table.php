<div>
    <?php
    $bd = DBConnection::getInstance()::getDB();
    ?>

    <?php if(!isset($_GET['table'])) { ?>
        <h1>Selecteaza tabel pentru inserare</h1>
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
                    <input type="hidden" name="page" value="insert_form" />

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
        echo "Vom insera in " . $_GET['table'];
    }?>
</div>