<!-- HTML - NavBar treatment -->
<div>
	<samp>Administrer :</samp>
	<!-- Admin controls -->
	<ul>
		<li>
			<!-- ?uChap  (.htAccess) -->
			<a href="author.manage-chapters">Gérer les chapitres</a>
		</li>
		<li>
			<!-- ?uPart  (.htAccess) -->
			<a href="author.manage-parts">Rédiger les épisodes</a>
		</li>
		<li>
			<?php 
				if ($commentaries !== null)
				{
					// ?uComm  (.htAccess) \\
					echo '<a href="author.manage-comments">Modérer les commentaires</a>';
				}
				else
				{
					echo '(Aucun commentaire)';
				}
			?>
		</li>
	</ul>
</div>