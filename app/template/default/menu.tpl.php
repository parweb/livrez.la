<? $Menu = new MenuModel; ?>
<? $menus = (array)$Menu->listes( array( 'orderby' => 'menu.order ASC' ) ); ?>

<ul id="menu">
	<? foreach ( $menus as $i => $item ) : ?>
		<li class="<?= $selected ?>">
			<a href="<?= link::href( url('module'), url('action') ) ?>"><?= $item['nom'] ?></a>
		</li>
	<? endforeach; ?>

	<? if ( user::is_admin() ) : ?>
		<li class="admin">
			<a href="#" class="top-level">Admin<span></span></a>
			<ul>
				<li><a href="<?= link::href( 'user', 'logout' ) ?>">Se déconnecter</a></li>
				<li><a href="<?= link::href( 'user', 'edit' ) ?>">Mon compte</a></li>
				<li><a href="<?= link::href( 'page', 'list' ) ?>">Les pages</a></li>
				<li><a href="<?= link::href( 'menu', 'list' ) ?>">Les menus</a></li>
				<li><a href="<?= link::href( 'user', 'list' ) ?>">Les utilisateurs</a></li>
			</ul>
		</li>
	<? endif; ?>
</ul>