<!-- HTML - NavBar treatment -->
<div class="r-flx flx-jst-sa">
	<!-- Welcome to user -->
	<a href='#' onclick='javascript:switch_connection();'>
		<?php 
			if ($admin) { echo '<i class="fas fa-2x fa-user-lock" title="Déconnexion..."></i>'; }
			elseif ($guest) { echo '<i class="fas fa-2x fa-user-secret" title="Connexion..."></i>'; }
			else { echo '<i class="fas fa-2x fa-user" title="Connexion..."></i>'; }
		?>
	</a>
	<?php if (!($admin)) { echo "<a href='#' onclick='javascript:switch_registration();'>"; } ?>
		<strong class="as-inblock" <?php if (!($admin)) { echo 'title="Enregistrer..."'; } ?>>
			<?php echo $userName; ?>
		</strong>
	<?php if (!($admin)) { echo "</a>"; } ?>
</div>

<!-- Connection/Disconnection -->
<?php include_once('views/connect.php'); ?>