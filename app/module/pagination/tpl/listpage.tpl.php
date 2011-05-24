<? include_once 'calcul_nb_page.php'; ?>

<? if ( $nb_page > 1 ) : ?>
	<div class="pagination">
		<span>page: </span>

		<ul>
			<? for ( $i = 1; $i <= $nb_page; $i++ ) : ?>
				<? $current = ''; if ( $i == url('page') ) $current = ' class="current"'; ?>
				
				<li<?= $current ?>><a href="<?= link::href( url('module'), url('action'), array( 'page' => $i ) ) ?>"><?= $i ?></a></li>
			<? endfor; ?>

			<div class="clear"></div>
		</ul>

		<div class="clear"></div>
	</div>
<? endif; ?>