<!-- HTML - NavBar treatment -->
<div class="c-flx flx-itm-st">
	<samp>Les chapitres :</samp>
	<!-- List of Chapters -->
	<select id="readChapter" onchange="switch_chapter()">
		<?php 
			if ($chapterList && count($chapterList) > 0)    // (->rowCount() if query)
			{
				echo '<option value="">Faîtes votre sélection...</option>';
				foreach ($chapterList as $data)
				{
					if ($data !== null)
					{
						// ?iChap (.htAccess) \\
						echo '<option value="chapter.read-' . $data['chap_title'] . '">' . $data['chap_title'] . '</option>';
					}
				}
			}
			else { echo '<option value="">Aucun chapitre...</option>'; }
		?>
	</select>
</div>