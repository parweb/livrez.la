<form method="post" enctype="multipart/form-data">
	<fieldset>
		<?= form::text( 'user.email', $User->email ) ?>
		<?= form::text( 'user.pseudo', $User->login ) ?>
		<?= form::password( 'user.password', '' ) ?>
	</fieldset>

	<?= form::hidden( 'action', 'add_user' ) ?>

	<? if ( url('action') == 'add' ) : ?>
		<?= form::submit( _( 'S\'inscrire' ) ) ?>
	<? else : ?>
		<?= form::submit( _( 'Modifier' ) ) ?>
	<? endif; ?>
</form>

<style type="text/javascript">
	var Email = new LiveValidation( "Email" );
	Email.add( Validate.Presence );
	Email.add( Validate.Email );

	var Pseudo = new LiveValidation( "Pseudo" );
	Pseudo.add( Validate.Presence );

	var Password = new LiveValidation( "Password" );
	Password.add( Validate.Presence );
	Password.add( Validate.Length, { minimum: 6 } );
</style>