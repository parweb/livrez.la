<? unset( $APPLI['limit'] ); ?>

<? $_ClassName = ucfirst( url('module') ); ?>
<? $_Class = new $_ClassName; ?>
<? $_nb_list = $_Class->listes( $APPLI, 'count' ); ?>

<? $nb_page = ceil( $_nb_list / url('limit') ); ?>