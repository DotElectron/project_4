<?php

//Session management...
// include_once('../controllers/user_selector.php');
// include_once('../controllers/main_selector.php');

?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>Jean Rochefort - Un billet en Alaska</title>   
    <!-- Metas -->
    <meta charset="utf-8">
    <meta name="language" content="fr-FR">
    <meta name="description" content="Projet de formation : créer un blog pour un écrivain. Le site répond au modèle MVC, PHP orienté objet, support MySQL avec interface d'administration,  librairie BootStrap pour la présentation, FontAwesome en soutien et police personnalisée.">
    <meta name="author" content="David ESQUIS">
    <meta name="viewport" content="width=device-width">
    <!-- Favicons -->
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <link rel="icon" href="favicon.png" type="image/png">
    <!-- Font Links -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anonymous+Pro:400,700">
    <!-- CSS Links -->
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- External JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <!-- Internal JavaScript -->
    <!-- <script src="public/js/anim.js"></script> -->
    <!-- FontAwesome 5.5.0 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/solid.css" integrity="sha384-rdyFrfAIC05c5ph7BKz3l5NG5yEottvO/DQ0dCrwD8gzeQDjYBHNr1ucUpQuljos" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/fontawesome.css" integrity="sha384-u5J7JghGz0qUrmEsWzBQkfvc8nK3fUT7DCaQzNQ+q4oEXhGSx+P2OqjWsfIRB8QT" crossorigin="anonymous">
</head>

<body>
    <!-- Header section -->
    <header class="theme-boxed theme-color theme-bckgrnd-color d-flex flex-row justify-content-between align-items-center">
        <!-- tmp: href "returnToReading" ? -->
        <a href=""><img src="public/img/book_jf.jpg" alt="Logo du livre de Jean Rochefort"></a>
        <h1>Jean Rochefort - Un billet en Alaska</h1>    
        <!-- Dynamic menu -->
        <nav class="theme-boxed">
            <?php 
                // include('../views/navbar.php'); 
            ?>
        </nav>
    </header>

    <!-- Main section -->
    <main>
        <?php 
            // include('../views/current_main.php'); 
        ?>
    </main>

    <!-- Footer section -->
    <footer class="theme-boxed theme-color theme-bckgrnd-color d-flex flex-row justify-content-center align-items-center">
        <p>Ce site est un projet de formation...</p>
    </footer>
</body>
</html>