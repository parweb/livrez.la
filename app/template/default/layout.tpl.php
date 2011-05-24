<? if ( url('ajax') ) : ?>
	<div id="title">
		<h1><?= $title ?></h1>
		<div class="clear"></div>
	</div>

	<? include $this->render( url('module'), url('action') ); ?>
<? else : ?>
<html>
	<head>
		<? include $this->layout( 'head' ); ?>
	</head>
	<body module="<?= url('module') ?>" action="<?= url('action') ?>" id="<?= _::clean( url('module').'_'.url('action') ); ?>"<? $more_module = ( url('admin') ) ? ' class="admin"' : ''; $more_module = ( url('ajax') ) ? ' class="ajax"' : ''; echo $more_module; ?>>
		<div id="container">
			<div id="header">
				<? include $this->layout( 'header' ); ?>
			</div>
			<div id="content">
				<div id="content-in">
					<div id="title">
						<h1><?= $title; ?></h1>
						<? $momomodule = ( url('module') == 'resultat' &&  url('action') == 'list' ) ? 'participation' : url('module'); ?>
	
						<? if ( user::is_admin() || user::is_secretaire() ) : ?>
							<div id="admin-bar">
								<?= button::link( 'Liste', link::href( url('module'), 'list' ) ) ?>
								<?= button::link( '+ Ajouter', link::href( $momomodule, 'add' ) ) ?>
	
								<? if ( url(':id') ) : ?>
									<?=  ' '.button::link( 'Edit', link::href( url('module'), 'edit', array( 'id' => url(':id') ) ) ) ?>
									<?=  ' '.button::link( '- Supprimer', link::href( url('module'), 'delete', array( 'id' => url(':id') ) ) ) ?>
								<? endif; ?>
							</div>
						<? endif; ?>
	
						<div class="clear"></div>
					</div>

					<?
					if ( isset( $menu ) ) {
						$INCLUDE_MENU = DIR_MODULE.url('module').DIRECTORY_SEPARATOR.'tpl'.DIRECTORY_SEPARATOR.'menu'.$_moduleClass.'.tpl.php';
						include( $INCLUDE_MENU );
					}
					?>

					<? if ( isset( $left ) ) : ?>
						<div id="left">
							<? foreach ( $left as $item ) : ?>
	
							<? endforeach; ?>
						</div>
					<? endif; ?>

					<div class="<?= url('module') ?> <?= url('action') ?>">
						<? include $this->render( url('module'), url('action') ); ?>
					</div>
					
					<? if ( isset( $right ) ) : ?>
						<div id="right">
							<? foreach ( $right as $item ) : ?>
	
							<? endforeach; ?>
						</div>
					<? endif; ?>
				</div>
			</div>
		</div>
		<div id="footer-wrap">
			<div id="footer">
				<? include $this->layout( 'footer' ); ?>
			</div>
		</div>
	</body>
</html>
<? endif; ?>