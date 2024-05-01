<?php
require_once __DIR__.'/includes/config.php';

$form = new es\ucm\fdi\aw\FormularioLogin();
$htmlFormLogin = $form->gestiona();
$tituloPagina = 'Login';
$contenidoPrincipal = <<<EOS
$htmlFormLogin
EOS;

require __DIR__.'/includes/vistas/plantilla.php';

?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <?php //require_once __DIR__. "/includes/vistas/topbar.php" ;?>
    <div class="login-container">
        <h2>Login</h2>
        <form action="process_login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Login</button>
            </div>
        </form>
    </div>
    
    <?php //require_once __DIR__. "/includes/vistas/footer.php" ;?>
</body>
</html> -->
