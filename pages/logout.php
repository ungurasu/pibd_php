<div class="py-5"">
    <h1>Deconectare</h1>

    <?php
        session_destroy();
        unset($_SESSION);
    ?>

    <div class="alert alert-success">Te-ai deconectat cu succes. Vei fi redirectionat...</div>
    <meta http-equiv="refresh" content="5; url=/" />
</div>