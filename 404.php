<?php require("translator.php") ?>

<!DOCTYPE html>
<html lang="en">
<?php require("head.php") ?>

<body class="overflow-y-auto font-default overflow-x-hidden">
    <div class="sticky top-0 shadow-md bg-white z-10">
        <?php require("navbar.php"); ?>
    </div>
    <!-- Hero Section 404 -->
    <section class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4">
        <h1 class="text-7xl font-extrabold text-primary mb-4">404</h1>
        <h2 class="text-2xl md:text-3xl font-semibold mb-2 text-gray-800"><?= $page_translations['title'] ?></h2>
        <p class="text-gray-600 mb-6"><?= $page_translations['description'] ?></p>
        <a href="/" class="inline-block px-6 py-3 bg-primary text-white rounded-full shadow hover:bg-primary-dark transition"><?= $page_translations['back_home'] ?></a>
    </section>
    <?php require("footer.php"); ?>
</body>

</html>