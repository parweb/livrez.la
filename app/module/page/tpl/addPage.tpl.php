<form method="post" enctype="multipart/form-data">
	<fieldset>
		<?= form::text( 'page.title', $Page->title ) ?>
		<?= form::textarea( 'page.content', $Page->content ) ?>
	</fieldset>

	<? if ( url('action') == 'add' ) : ?>
		<?= form::submit( _( 'Ajouter la page' ) ) ?>
	<? else : ?>
		<?= form::submit( _( 'Modifier la page' ) ) ?>
	<? endif; ?>
</form>