<?php
    require 'DBConnection.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>PIBD</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

        <style>
            #main-container {
                margin-top: 30px;
            }
        </style>
    </head>
    <body>
        <?php
            session_start();

            // Verificam daca utilizatorul este conectat
            $logged_in = isset($_SESSION['is_logged_in']);
            if(!$logged_in)
                $page = 'login';
            else {
                $page = 'home';
                if (isset($_GET['page'])) {
                    // TODO: validam daca calea specificata de utilizator ramane in folderul "pages"

                    if (file_exists("pages/{$_GET['page']}.php"))
                        $page = $_GET['page'];
                }
            }
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="/">PIBD</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item<?= $page == 'home' ? ' active' : '' ?>">
                        <a class="nav-link" href="/">Acasa</a>
                    </li>
                    <?php if($logged_in) { ?>
                        <li class="nav-item<?= $page == 'show_table' ? ' active' : '' ?>">
                            <a class="nav-link" href="/?page=show_table">Vezi tabel</a>
                        </li>
                        <li class="nav-item<?= $page == 'insert_select_table' ? ' active' : '' ?>">
                            <a class="nav-link" href="/?page=insert_select_table">Insereaza</a>
                        </li>
                    <?php } ?>
                </ul>

                <?php if($logged_in) { ?>
                    <span class="navbar-text">
                        Conectat ca <?= $_SESSION['db_username'] ?>@<?= $_SESSION['db_hostname'] ?>
                    </span>
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="?page=logout">Deconectare</a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </nav>

        <div class="container py-5" id="main-container">
            <?php
                if(!empty($_SESSION['message'])) {
                    $message = $_SESSION['message'];
                    $_SESSION['message'] = null;

                    ?>

                    <div class="alert alert-<?= $message['message_color'] ?>" role="alert">
                        <h4 class="alert-heading"><?= $message['heading'] ?></h4>
                        <p><?= nl2br($message['message']) ?></p>
                    </div>

                    <?php
                }
            ?>

            <?php
                try {
                    require "pages/{$page}.php";
                } catch (Exception $e) {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Am intampinat o eroare!</h4>
                            <p>In executia acestei pagini, am intampinat o eroare. Puteti vedea mesajul mai jos.</p>
                            <hr>
                            <p class="small">In fisierul <?= $e->getFile() ?>, la linia <?= $e->getLine() ?>:</p>
                            <p class="mb-0"><?= nl2br($e->getMessage()) ?></p>
                        </div>
                    <?php
                }
            ?>
        </div>
    </body>
</html>


