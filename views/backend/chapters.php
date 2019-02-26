<!-- HTML - Chapters management -->
<div id="a-m-chapters" class="c-flx flx-wrp">
    <h2 class="theme-color theme-boxed-shadow theme-bckgrnd-color theme-boxed">Gestion des chapitres du livre</h2>
    <div class="c-flx flx-itm-st theme-dashed theme-dark-color theme-bckgrnd-color">
        <?php
            if ($chapterList && count($chapterList) > 0)    // (->rowCount() if query)
            {
                $_order = 0;
                foreach ($chapterList as $data)
                {
                    // ?iChap (.htAccess) \\
                    echo '<p id="chap-' . $_order . '">';
                        echo '<a href="#chapt-' . $_order . '" onclick="javascript:switch_adm_chapter();">';
                            echo '<span id="chap-s--' . $_order . '">' . $data['chap_title'] . '</span>';
                            echo '<i id="chap-i--' . $_order . '" class="fas fa-pencil-alt" title="Modifier le chapitre..."></i>';
                        echo '</a>';
                        echo '<a href="#chapt-' . $_order . '" onclick="javascript:switch_adm_chapter();">';
                            echo '<i id="chap-d--' . $_order . '" class="fas fa-trash-alt" title="Supprimer le chapitre..."></i>';
                        echo '</a>';
                        if ($_order < (count($chapterList) - 1))    // (->rowCount() if query)
                        {
                            echo '<a href="#chapt-' . $_order . '" onclick="javascript:document.getElementById(\'chap-fmu--'. $_order . '\').submit();">';
                                echo '<i id="chap-mu--' . $_order . '" class="fas fa-caret-down" title="Descendre..."></i>';
                            echo '</a>';
                        }
                        if ($_order > 0)
                        {
                            echo '<a href="#chapt-' . $_order . '" onclick="javascript:document.getElementById(\'chap-fmd--'. $_order . '\').submit();">';
                                echo '<i id="chap-md--' . $_order . '" class="fas fa-caret-up" title="Monter..."></i>';
                            echo '</a>';
                        }
                    echo '</p>';
                    echo '<form id="chap-f--' . $_order . '" class="hidden-tag chap-tag" action="#chap-' . $_order . '" method="POST"> ';
                        echo '<input type="hidden" name="admLastData" value="' . $data['chap_title'] . '"/>';
                        echo '<input type="text" name="admChapter" placeholder="Titre du chapitre" value="' 
                                . $data['chap_title'] . '" maxlength="60" size="' . strlen($data['chap_title']) . '" required/>';
                        echo '<input type="submit" value="Modifier"/>';
                    echo '</form>';
                    echo '<form id="chap-fd--'. $_order . '" class="hidden-tag chap-tag chap-form" action="#" method="POST"> ';
                        echo '<input type="hidden" name="admLastData" value="' . $data['chap_title'] . '"/>';
                        echo '<input type="hidden" name="admDelChapter" value="¤"/>';
                        echo '<input type="submit" id="chap-fs--'. $_order . '" value="Confirmer la suppression"/>';
                    echo '</form>';
                    echo '<form id="chap-fmu--'. $_order . '" class="hidden-tag" action="#chap-' . ($_order + 1) . '" method="POST"> ';
                        echo '<input type="hidden" name="admLastData" value="' . $data['chap_title'] . '"/>';
                        echo '<input type="hidden" name="admMoveChapter" value="' . ($_order + 1) . '"/>';
                        echo '<input type="submit"'. $_order . '" value="Confirmer la suppression"/>';
                    echo '</form>';
                        echo '<form id="chap-fmd--'. $_order . '" class="hidden-tag" action="#chap-' . ($_order - 1) . '" method="POST"> ';
                        echo '<input type="hidden" name="admLastData" value="' . $data['chap_title'] . '"/>';
                        echo '<input type="hidden" name="admMoveChapter" value="' . ($_order - 1) . '"/>';
                        echo '<input type="submit"'. $_order . '" value="Confirmer la suppression"/>';
                    echo '</form>';
                    $_order++;
                }
                $_order = null;
            }
        ?>
        <div id="a-m-chapters--new" class="c-flx">
            <p id="new-chap">
                <a href="#new-chapt" onclick="javascript:switch_adm_toNewChap();">
                    <i class="fas fa-pencil-ruler"></i>
                    <span id="chap-s--new-chap">Ajouter un nouveau chapitre</span>
                    <i class="fas fa-pencil-ruler"></i>
                </a>
            </p>
            <form id="chap-f--new-chap" class="hidden-tag chap-tag" action="#new-chapt" method="POST">
                <input type="hidden" name="admLastData" value="<?php if ($chapterList) { echo count($chapterList); } else { echo '0'; } ?>"/>
                <input type="text" name="admNewChapter" placeholder="Titre du chapitre" value="" maxlength="60" size="30" required/>
                <input type="submit" value="Ajouter"/>
            </form>
        </div>
    </div>
</div>