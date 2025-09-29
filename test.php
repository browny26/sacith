<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test .htaccess</title>
</head>

<body>
    <h1>Test .htaccess</h1>
    <p>Se vedi questa pagina, il rewrite dell'.htaccess funziona correttamente!</p>
    <p>URL richiesta: <strong><?php echo $_SERVER['REQUEST_URI']; ?></strong></p>
    <?php phpinfo(); ?>
</body>

</html>