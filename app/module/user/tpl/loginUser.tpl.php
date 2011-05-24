<form method="post">
	<?= form::text( 'login', $User->login ) ?>
	<?= form::password( 'mdp', $User->pass ) ?>
	<?= form::none( '<input type="submit" value="Login !" class="form-submit"> '.button::link( 'S\'inscrire !', link::href( 'user', 'add' ) ) ) ?>
</form>