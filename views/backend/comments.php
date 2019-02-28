<!-- HTML - Comments management -->
<div id="a-m-comments" class="c-flx flx-wrp spacing">
    <h2 class="theme-color theme-boxed-shadow theme-bckgrnd-color theme-boxed">Modérer les commentaires du livre</h2>
    <div id="a-m-comments-lite" class="c-flx theme-dashed theme-dark-color theme-bckgrnd-color spacing lite-container">
		<div class="r-flx flx-wrp">
			<label title="Pensez à rafraichir après l'avoir modifier...">
				<input id="comm-swapper" type="checkbox" onclick="javascript:muteSwap();"/>
				Commentaires masqués ?
			</label>
			<a href="#refresh" title="Rafraichir la liste..." onclick="javascript:flagSwap();">
				<i class="fas fa-redo-alt"></i>
			</a>
		</div>
		<?php
			if ($commList && count($commList) > 0)    // (->rowCount() if query)
			{
				foreach ($commList as $data)
				{
					echo '<div class="inner-comment theme-marked">';
						echo '<p class="encaps theme-bckgrnd-light-mask"><span class="advert">Episode concerné : </span>' . $data['part_short_title'] . '</p>';
						echo '<span class="user-info"><span class="advert">Publié par : </span>' . $data['com_author'] . '</span>';
						echo '<span class="advert spacing">Nombre de signalement(s) : ' . $data['com_flag'] . '</span>';
						echo '<a href="#mute" onclick="javascript:muteComment();">';
							echo '<i id="com-rm--' . $data['com_id'] . '" class="user-mask fas';
							if (!($data['com_muted'])) { echo ' fa-eye user-info" title="Retirer le commentaire..."></i>'; }
							else { echo ' fa-eye-slash user-alert" title="Remettre le commentaire..."></i>'; }
						echo '</a>';
						echo '<p class="user-info theme-bckgrnd-mask theme-strip-shadow">' . stripslashes($data['com_text']) . '</p>';
					echo '</div>';
				}
			}
			else { echo '<p class="user-info user-warning">Aucun commentaire n\'a été récemment signalé...</p>'; }
    	?>
    </div>
</div>