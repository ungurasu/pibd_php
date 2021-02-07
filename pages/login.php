<div class="py-5"">
    <h1>Conecteaza-te</h1>
    <p class="lead">Conecteaza-te la baza de date.</p>

    <?php
        $errors = [];
        $connection_successful = false;

        if(!empty($_POST)) {
            // Validam datele
            $required_fields = ['hostname', 'username', 'password', 'database'];
            foreach($required_fields as $field) {
                if (!isset($_POST[$field]) || empty($_POST[$field]))
                    $errors[] = "Campul '$field' este necesar";
            }

            $hostname = $_POST['hostname'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $database = $_POST['database'];

            // Silence warnings
            error_reporting(0);

            // Vedem daca ne putem conecta la baza de date
            $db = new mysqli($hostname, $username, $password, $database);

            if($db->connect_errno)
                $errors[] = "Nu m-am putut conecta la baza de date: " . $db->connect_error;
            else
                $connection_successful = true;

            error_reporting(E_ALL);

            if($connection_successful) {
                $_SESSION['db_hostname'] = $hostname;
                $_SESSION['db_username'] = $username;
                $_SESSION['db_password'] = $password;
                $_SESSION['db_database'] = $database;
                $_SESSION['is_logged_in'] = true;
            }
        }
    ?>

    <?php if(!empty($errors)) { ?>
        <div class="alert alert-danger">
            <h4 class="alert-heading">Am intampinat o eroare!</h4>
            <p>Am intampinat o eroare la conectarea la baza de date. Va rugam sa verificati datele.</p>
            <hr>

            <?php foreach($errors as $error) { ?>
                <p><?= nl2br($error) ?></p>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if($connection_successful) { ?>
        <div class="alert alert-success">Te-ai conectat cu succes la baza de date. Vei fi redirectionat...</div>
        <meta http-equiv="refresh" content="5; url=/" />
    <?php } else { ?>
        <form action="/?page=login" method="post">
            <div class="form-group">
                <label for="hostname">Gazda</label>
                <input type="text" class="form-control" id="hostname" name="hostname" required>
                <small class="form-text text-muted">ex. localhost, mydb.example.com</small>
            </div>
            <div class="form-group">
                <label for="username">Nume de utilizator</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <small class="form-text text-muted">ex. root, gigel</small>
            </div>
            <div class="form-group">
                <label for="password">Parola</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="database">Baza de date</label>
                <input type="text" class="form-control" id="database" name="database" required>
            </div>

            <button type="submit" class="btn btn-primary">Conectare</button>
        </form>
    <?php } ?>
</div>
