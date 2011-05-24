<? if ( count( $list ) > 0 ) : ?>
	<div id="<?= url('action') ?>_<?= url('module') ?>">
		<? foreach ( $list as $item ) : ?>
			<div class="item <?= url('module') ?>">
				<div class="titre"><a href="<?= link::href( 'user', 'edit', array( 'id' => $item['id'] ) ) ?>"><?= $item['login'] ?></a></div>
			</div>
		<? endforeach; ?>
	</div>

	<div class="clear"></div>
<? else : ?>
	<p>Aucun résultat <br /><a href="<?= link::href( 'user/add' ) ?>">Ajouter un user</a></p>
<? endif; ?>