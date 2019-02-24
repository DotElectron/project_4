<!-- HTML - Parts management -->
<div id="a-m-parts" class="c-flx flx-wrp spacing"> <!-- onload="tiny_initialize()"> -->
    <h2 class="theme-color theme-boxed-shadow theme-bckgrnd-color theme-boxed">Rédiger les épisodes du livre</h2>
    <div id="a-m-parts-lite" class="c-flx theme-dashed theme-dark-color theme-bckgrnd-color spacing lite-container">
        <form id="sel-edit" class="lite-spacing r-flx flx-jst-sb theme-boxed-shadow" method="GET">
            <div>
                <label for="chapter">Chapitre : </label>
                <select id="chap-selector" name="chapter" required onchange="chapterSubmit()">
                    <option value="draft" <?php if ($selectedChapter === null) { echo ' selected'; } ?>>Brouillon...</option>
                    <?php 
                        if ($chapterList && $chapterList->rowCount() > 0)
                        {
                            foreach ($chapterList as $data)
                            {
                                echo '<option value="' . $data['chap_title'] . '"';
                                if ($selectedChapter !== null
                                    && $selectedChapter === $data['chap_title'])
                                {
                                    echo ' selected';
                                }
                                echo '>' . $data['chap_title'] . '</option>';
                            }
                        }
                        else { $noChapter = true; }
                    ?>
                </select>
            </div>
            <div>
                <label for="part" class="cCase">épisode : </label>
                <select id="part-selector" name="part" required onchange="selectedSubmit()">
                    <option value="new" <?php if ($selectedPart === null) { echo ' selected'; } ?>>Nouveau...</option>
                    <?php 
                        if ($partList && count($partList) > 0)
                        {
                            foreach ($partList as $data)
                            {
                                echo '<option value="' . $data['part_order'] . '"';
                                if ($selectedPart !== null
                                    && $selectedPart === $data['part_order'])
                                {
                                    echo ' selected';
                                }
                                if ($data['part_subtitle'] !== null)
                                {
                                    echo '>' . $data['part_subtitle'] . '</option>';
                                }
                                else
                                {
                                    echo '>' . html_entity_decode(substr($data['part_text'], 0, 60)) . '</option>';
                                }
                            }
                        }
                    ?>
                </select>
            </div>
        </form>
        <?php if (isset($noChapter)) { echo '<p class="user-alert">Vous devrez créer un chapitre pour publier l\'épisode.</p>'; } ?>
        <div class="r-flx flx-jst-sa form-container">
            <form id="part-edit" action="#save-part" method="POST" onsubmit="getContentToSubmit()">
                <label for="admSubtitle">Titre de l'épisode : </label>
                <input type="text" id="adm-subtitle" name="admSubtitle" placeholder="(optionnel)" 
                    value="<?php if ($selPartData !== null) { echo $selPartData->getSubtitle(); } ?>" maxlength="60" size="30"/>
                <input type="submit" value="Enregistrer l'épisode"/>
                <input type="hidden" name="admRegister" value="¤"/>
                <input type="hidden" id="hidden-part" name="admHtmlText" value=""/>
            </form>
            <form id="part-reorder" action="#move-part" method="POST">
                <input type="hidden" name="admMovePart" value="<?php echo $selectedPart; ?>"/>
                <label for="admMoveBefore">Mettre avant : </label>
                <select name="admMoveBefore" required>
                    <?php 
                        if ($partList && count($partList) > 1)
                        {
                            foreach ($partList as $data)
                            {
                                if ($selectedPart === null
                                    || $selectedPart != $data['part_order'])
                                {
                                    echo '<option value="' . $data['part_order'] . '"';
                                    if ($data['part_subtitle'] !== null)
                                    {
                                        echo '>' . $data['part_subtitle'] . '</option>';
                                    }
                                    else
                                    {
                                        echo '>' . html_entity_decode(substr($data['part_text'], 0, 60)) . '</option>';
                                    }
                                }
                            }
                        }    
                    ?>     
                </select>
                <input type="submit" value="Déplacer l'épisode"/>
            </form>
            <form id="part-delete" action="#del-part" method="POST">
                <input type="hidden" name="admDelPart" value="<?php echo $selectedPart; ?>"/>
                <input type="button" class="user-warning" value="Supprimer l'épisode" onclick="confirmBeforeSubmit()"/>            
            </form>
        </div>
        <div class="lite-container">
            <textarea id="editable-part"></textarea>
        </div>
    </div>
</div>

<script>
    // Tiny-MCE...
    tiny_initialize(<?php if ($selPartData !== null) { echo '"' . strip_tags(html_entity_decode($selPartData->getHtmlText())) . '"'; } ?>);
</script>