<div class="py-5">
    <?php
    $bd = DBConnection::getInstance()::getDB();
    ?>

    <?php if(isset($_GET['table'])) { ?>
        <h1>Insereaza datele in tabelul <?php printf("%s",$_GET['table'])?></h1>

        <?php
        $columns_querry = $bd->query(sprintf("SHOW COLUMNS FROM %s;",$_GET['table']));
        ?>
        <form action="/?page=insert_action&table=<?php printf("%s",$_GET['table'])?>" method="post">
            <?php
            foreach ($columns_querry as $column) {
                if ($column["Extra"] != 'auto_increment') {?>
                    <div class="form-group">
                        <label>Camp: <?php printf("%s",$column["Field"])?></label>
                        <input type="text" class="form-control" id="<?php printf("%s",$column["Field"])?>" name="<?php printf("%s",$column["Field"])?>" required>
                        <small class="form-text text-muted">Tip: <?php printf("%s",$column["Type"])?></small>
                    </div>
            <?php
                }
            }
            ?>
            <button type="submit" class="btn btn-primary">Insereaza</button>
        </form>
    <?php } ?>
</div>
