<!-- HTML - connection treatment -->
<div id="connect" class="c-flx hidden-tag">
	<form action="." method="POST"> 
		<?php 
			if ($admin) { echo '<input type="hidden" name="accHash" value="@"/>'; }
			else { echo '<input type="password" name="accHash" placeholder="Mot de passe" value="" maxlength="20" size="10" required/>'; }
			echo '<input type="submit" value=';
			if ($admin) { echo 'Déconnexion />'; }
			else { echo 'Connexion />'; }
		?>
	</form> 
</div>

<div id="register" class="c-flx hidden-tag">
	<form action="." method="POST"> 
		<input type="text" name="accUser" placeholder="Pseudonyme" value="" maxlength="30" size="15" required/>
		<input type="submit" value="Enregistrer"/>
	</form> 
</div>
