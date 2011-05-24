<form method="post" enctype="multipart/form-data">
	<fieldset>
		<?= form::text( 'menu.nom', $Menu->nom ) ?>
		<?= form::text( 'menu.sub', $Menu->sub ) ?>
		<?= form::text( 'menu.uri', $Menu->uri ) ?>
		<?= form::numeric( 'menu.order', $Menu->order ) ?>
	</fieldset>

	<?= form::hidden( 'action', 'add_menu' ) ?>

	<? if ( url('action') == 'add' ) : ?>
		<?= form::submit( _( 'Ajouter le menu' ) ) ?>
	<? else : ?>
		<?= form::submit( _( 'Modifier le menu' ) ) ?>
	<? endif; ?>
</form>