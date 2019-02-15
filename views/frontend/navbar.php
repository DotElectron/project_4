<!-- HTML - NavBar treatment -->
<div>
	<samp>Les chapitres :</samp>
	<!-- List of Chapters -->
	<ul>
		<?php 
			if ($chapterList && $chapterList->rowCount() > 0)
			{
				foreach ($chapterList as $data)
				{
					echo '<li><a href="?iChap=' . $data['chap_id'] . '">' . $data['chap_title'] . '</a></li>';
				}
			}
			else { echo '<li>Aucun chapitre...</li>'; }
		?>
	</ul>
</div>