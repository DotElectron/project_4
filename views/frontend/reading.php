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
                        echo '<span class="user-info"><i class="fas fa-star user-info"></i>' . $data['part_order'] . '</span>';
                        if ($data['part_subtitle'] !== null)
                        {
                            echo '<h3>' . $data['part_subtitle'] . '</h3>';
                        }
                        echo stripslashes($data['part_text']);
                        echo '<div class="master-comment" id="comments-' . $data['part_order'] . '">';
                            echo '<a href="#comments" onclick="javascript:expandComments();">';
                                echo '<i id="com-i--' . $data['part_order'] . '" class="fas fa-2x fa-angle-double-down" title="Consulter les commentaires..."></i>';
                            echo '</a>';
                            echo '<div id="com-d--' . $data['part_order'] . '" class="hidden-tag part-tag">';
                                echo '<form id="com-f--' . $data['part_order'] . '" action="#comments-' . $data['part_order'] . '" method="POST"> ';
                                    echo '<input type="hidden" name="userNewComm" value="' . $data['part_order'] .'"/>';
                                    echo '<input type="hidden" id="com-c--' . $data['part_order'] . '" name="userComment" value=""/>';
                                    echo '<a href="#comments-post" onclick="javascript:submitComment();">';
                                        echo '<i id="com-s--' . $data['part_order'] . '" class="fas fa-2x fa-sign-in-alt comm-submit" title="Poster votre commentaire..."></i>';
                                    echo '</a>';
                                echo '</form>';
                                echo '<p id="com-l--' . $data['part_order'] . '" class="hidden-tag user-alert">Vous devez remplir le commentaire avant de poster...</p>';
                                echo '<textarea id="com-t--' . $data['part_order'] . '" placeholder="Vous pouvez laisser ici votre commentaire..." value="" rows="7" maxlength="512"></textarea>';
                                if ($data['comm_list'] && $data['comm_list']->rowCount() > 0)
                                {
                                    foreach ($data['comm_list'] as $commData)
                                    {
                                        echo '<div class="inner-comment theme-marked">';
                                            echo '<span class="user-info">' . $commData['com_author'] . '</span>';
                                            echo '<span class="user-info">' . $commData['com_date_fr'] . '</span>';
                                            echo '<a href="#alert" onclick="javascript:reportComment();">';
                                                echo '<i id="com-r--' . $commData['com_id'] . '" class="fas fa-exclamation-triangle user-info user-mask comm-tag" title="Signaler le commentaire..."></i>';
                                            echo '</a>';
                                            echo '<p class="user-info theme-bckgrnd-mask">' . stripslashes($commData['com_text']) . '</p>';
                                        echo '</div>';
                                    }
                                }
                            echo '</div>';
                        echo '</div>';
                    echo '</article>';
                }
            }
        ?>
    </div>
        </section>