<?php

class PageControler extends AppControler {
	public function before () {
		//user::need( array( 'admin' ) );

		$this->breadcrump( 'Page' );
	}

	public function after () {
		//
	}
	
	protected function submit () {
		if ( $this->validate() ) {
			$id = $this->save();

			if ( $id ) {
				url::redirect( "page/list/$id/" );
			}
		}
	}

	public function viewAction () {
		$this->view( 'title', $this->title );
	}

	public function addAction () {
		$this->view( 'title', 'Ajouter une page' );
		$this->breadcrump( 'Ajouter' );
		
		$this->submit();
	}

	public function editAction () {
		$this->view( 'title', 'Edition d\'une page' );
		$this->breadcrump( 'Editer' );

		$this->submit();
	}

	public function deleteAction () {
		$this->view( 'title', 'Supprimer d\'une page' );
		$this->breadcrump( 'Supprimer' );

		$id = $this->delete();
		
		if ( $id ) {
			url::redirect( "page/list/" );
		}
	}

	public function listAction () {
		$this->view( 'title', 'Liste des pages' );
		$this->view( 'description', '' );
		$this->breadcrump( 'Liste' );
	}
}

/*
$TPL['breadcrump'][] = _( 'Page' );

switch ( $URL['action'] ) {
	case 'view':
		$TPL['title'] = $Page->title;
	break;

	case 'edit':
	case 'add':
		user::need( array( 'admin' ) );

		if ( $URL['action'] == 'add' ) {
			$TPL['title'] = _( 'Ajouter une page' );
			$TPL['breadcrump'][] = _( 'Ajouter' );
		}
		else {
			$TPL['title'] = _( 'Modifier une page' );
			$TPL['breadcrump'][] = _( 'Modifier' );
		}

		if ( count( $_POST ) ) {
			if ( $URL['action'] == 'add' ) {
				$new_id = $Page->add( $_POST );
			}
			else {
				$new_id = $URL[':id'];
				$Page->save( $new_id, $_POST );
			}

			url::redirect( link::href( 'page', 'list' ) );
		}
	break;

	case 'delete':
		user::need( array( 'admin' ) );

		$TPL['title'] = _( 'Supprimer une page' );
		$TPL['breadcrump'][] = _( 'Supprimer' );

		$Page->delete( $URL[':id'] );

		if ( $URL[':id'] ) {
			url::redirect( link::href( 'page', 'list' ) );
		}
	break;

	default:
		user::need( array( 'admin' ) );

		$TPL['title'] = _( 'Liste des pages' );
		$TPL['description'] = '';
		$TPL['breadcrump'][] = _( 'Liste' );
	break;
}
*/