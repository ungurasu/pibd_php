<div class="py-5">
    <?php
    $bd = DBConnection::getInstance()::getDB();
    ?>

    <?php if(isset($_GET['table'])) { ?>
        <h1>Insereaza datele in tabelul <?php printf("%s",$_GET['table'])?></h1>

        <?php
        $columns = $bd->query(sprintf("SHOW COLUMNS FROM %s;",$_GET['table']));

        ?>
        <form action="/" method="get">
            <>
        </form>
    <?php } ?>
</div>
