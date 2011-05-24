<?php

class CoreControler {
	protected $breadcrump = array();
	public $view;

	public $module;
	public $action;
	
	public $template;
	public $layout;

	public function init () {
		$module = url('module');
		$Module = ucfirst($module);
		$Module_name = $Module.'Controler';
		$Model = $Module.'Model';

		$action = url('action').'Action';
		$option = url('where');

		$this->$Module = new $Model( url(':id', 0) );
		$this->view = new CoreView;

		$this->module =  url('module');
		$this->action = url('action');
		$this->layout = config('view.layout');
		$this->template = config('view.template');

		$this->view( $Module, $this->$Module );
		$this->view( 'list', $this->$Module->listes( url::url2appli( url::url2params() ) ) );

		foreach ( $this->$Module->many() as $item ) {
			$Item = ucfirst( $item );
			$sub_Model_name = $Item.'Model';		
			$SubModel = new $sub_Model_name;

			$this->$Item = $SubModel->listes( array( 'where' => array( 'id' => $this->$Module->{$item.'_id'} ) ) );
			$this->view( $Item, $this->$Item );
		}

		$this->before();

		$Reflection = new ReflectionClass( $this );

		if ( $Reflection->hasMethod( $action ) ) {
			call_user_func( array( $this, $action ) );
		}
		else {
			exit( "La methode $ModuleControler->$action( ".join( ', ', $option )." ) na put etre appelé <br />soit elle n'existe pas ou elle nest pas en public<br />le fichier devrait se trouver ".DIR.APP.MODULE.$module.DS.$Module."Controler.php ;)" );
		}

		$this->after();
		$this->render();
	}

	public function after () {
		$this->view->run( $this );
	}

	public function render () {
		$this->view->run( $this );
	}

	public function before () {
	
	}

	public function validate () {
		if ( count( $_POST ) ) {
			echo '<pre>'.__FILE__.' ( '.__LINE__.' ) ';
				print_r( $_POST );
			echo '</pre>';
		}
		else {
			return false;
		}
	}

	public function breadcrump ( $data = null ) {
		if ( is_array( $data ) ) {
			$this->breadcrump = array_merge( $breadcrump, $data );
		}
		else if ( is_string( $data ) ) {
			$this->breadcrump[] = $data;
		}
		else {
			return $this->breadcrump;
		}
	}

	public function view ( $key, $val = null ) {
		$this->view->add( $key, $val );
	}
}