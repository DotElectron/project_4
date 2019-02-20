<!-- HTML - NavBar treatment -->
<div>
	<samp>Administrer :</samp>
	<!-- Admin controls -->
	<ul>
		<li>
			<a href="?uChap">Gérer les chapitres</a>
		</li>
		<li>
			<a href="?uPart">Rédiger les épisodes</a>
		</li>
		<li>
			<?php 
				if ($commentaries !== null)
				{
					echo '<a href="?uComm">Modérer les commentaires</a>';
				}
				else
				{
					echo '(Aucun commentaire)';
				}
			?>
		</li>
	</ul>
</div>