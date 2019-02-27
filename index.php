<?php

namespace Rochefort;

//Error Management...
require_once('models/Error_manager.php');
use Rochefort\Classes\Error_manager;
$activeDebug = true;
// $activeTest = true;

//Session management...
session_name('PhpRootSession');
if (session_start())
{
    $_SESSION['activeDebug'] = $activeDebug;
    if (isset($activeDebug) || isset($activeTest)) 
    { 
        Error_manager::setErr('[Session is loaded]'); 
        Error_manager::setErr('* * * PHP version: ' . phpversion() . ' * * *');
    }
    if (!(isset($activeTest)))
    { 
        require_once('controllers/user_selector.php'); 
        Controllers\userSelector(); 
    }
}
else { Error_manager::setErr('Error: session is down !'); }

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
    <!-- External CSS Links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/solid.css" integrity="sha384-rdyFrfAIC05c5ph7BKz3l5NG5yEottvO/DQ0dCrwD8gzeQDjYBHNr1ucUpQuljos" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/fontawesome.css" integrity="sha384-u5J7JghGz0qUrmEsWzBQkfvc8nK3fUT7DCaQzNQ+q4oEXhGSx+P2OqjWsfIRB8QT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anonymous+Pro:400,700">
    <!-- Internal CSS Links -->
    <link rel="stylesheet" type="text/css" href="public/css/adv-flex-style-min.css">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <!-- External JavaScript -->
    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=0j0otcebzd9e4f92cv5nw7zzzyyt9ihnb6sbvkeeoexb3tws"></script>
    <!-- Internal JavaScript -->
    <script src="public/js/main.js"></script>
    <script src="public/js/navbar.js"></script>
    <script src="public/js/admin.js"></script>
    <script src="public/js/user.js"></script>
    <script src="public/js/ajax.js"></script>
    <script src="public/js/tiny-mce--fr.js"></script>
</head>

<body onload="body_adjustement()">
    <!-- Header section -->
    <header class="theme-boxed theme-color theme-bckgrnd-color r-flx flx-jst-sb">
        <!-- tmp: href "returnToReading" ? -->
        <a href="."><img src="public/img/book_jf.jpg" alt="Logo du livre de Jean Rochefort"></a>
        <h1 class="c-flx"><span class="title">Jean Rochefort</span> --- 
            <div class="r-flx"><span class="as-inblock">Un billet</span><em> </em><span class="as-inblock">en Alaska</span></div>
            <?php 
                if (isset($activeDebug) || isset($activeTest))
                {
                    $version = "alpha";
                    if (!(isset($activeTest))) { $version = "beta"; }
                    echo '<em></em><span class="as-inblock">(' . $version . ' version)</span>'; 
                }
            ?>
        </h1>    
        <!-- Dynamic menu -->
        <nav class="theme-boxed">
            <?php if (!(isset($activeTest))) { include_once('controllers/nav_selector.php'); } ?>
        </nav>
    </header>

    <!-- Main section -->
    <main class="c-flx">
        <?php 
            if (isset($activeDebug) || isset($activeTest)) 
            { 
                echo '<div class="c-flx flx-jst-st theme-boxed debug-area">'; 
                // You can push here your instant unit test...
                // OR include of your external test file.
                if (isset($activeTest)) { include_once('controllers/test_file.php'); }

                //Final display...
                Error_manager::displayErr();
                echo '</div>';
            }
        ?>   
        <div id="data-area" class="c-flx flx-wrp">
            <?php 
                if (!(isset($activeTest))) { include_once('controllers/main_selector.php'); } 
                else { echo 'Alpha version is working, no content available...'; }
            ?>
        </div>
        <?php
            if (!(isset($activeTest)))
            {
                echo '<div id="last-debug" class="c-flx flx-jst-st theme-boxed debug-area">'; 
                if (!(isset($activeDebug))) { echo '<i class="fas fa-2x fa-clipboard-check theme-color"></i>'; }
                Error_manager::displayErr();
                echo '</div>';
            }
        ?>
    </main> 

    <!-- Footer section -->
    <footer class="theme-boxed theme-color theme-bckgrnd-color c-flx">
        <span>Ce site est un projet de formation...</span>
        <!-- Add a front z-index to alert about cookies usage -->
    </footer>
</body>
</html>