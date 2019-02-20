<!-- HTML - NavBar treatment -->
<div class="c-flx flx-itm-st">
	<samp>Les chapitres :</samp>
	<!-- List of Chapters -->
	<select id="readChapter" onchange="switch_chapter()">
		<?php 
			if ($chapterList && $chapterList->rowCount() > 0)
			{
				echo '<option value="">Faîtes votre sélection...</option>';
				foreach ($chapterList as $data)
				{
					echo '<option value="?iChap=' . $data['chap_title'] . '">' . $data['chap_title'] . '</option>';
				}
			}
			else { echo '<option value="">Aucun chapitre...</option>'; }
		?>
	</select>
</div>