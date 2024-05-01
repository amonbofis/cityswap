<!DOCTYPE html>
<html lang='es'>
<head>
	<meta charset="UTF-8">
    <title><?= $tituloPagina ?></title>
	
	<link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
        require "includes/vistas/topbar.php";
    ?>
    <div id="contenedor">
        <main>
            <article>
                <?= $contenidoPrincipal ?>
            </article>
        </main>
    </div>
    <?php
        require "includes/vistas/footer.php";
    ?>
</body>
</html>
