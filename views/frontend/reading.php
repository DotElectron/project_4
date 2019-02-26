<!-- HTML - Reading data -->
<section id="i-reader--container" class="c-flx flx-wrp spacing"> <!-- onload="tiny_initialize()"> -->
    <h2 class="theme-color theme-boxed-shadow theme-bckgrnd-color theme-boxed"><?php echo $chapterClassObject->getTitle(); ?></h2>
    <div id="i-reader-parts--container" class="r-flx flx-wrp theme-dashed theme-dark-color theme-bckgrnd-color">
        <?php 
            if ($partList && count($partList) > 0)
            {
                foreach ($partList as $data)
                {
                    echo '<article>';
                        if ($data['part_subtitle'] !== null)
                        {
                            echo '<h3>' . $data['part_subtitle'] . '</h3>';
                        }
                        echo stripslashes($data['part_text']);
                    echo '</article>';
                }
            }
        ?>
    </div>
        </section>