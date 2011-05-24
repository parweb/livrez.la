<?php

class AppControler extends CoreControler {
	public function init () {
		css::add(
			'reset',
			'jquery-ui',
			'style',
			//'jquery.cleditor',
			'zoombox',
			'print'
		);

		js::add(
			'jquery',
			'jquery.ui',
			'livevalidation',
			//'jquery.upload-1.0.2.min',
			//'jquery.cleditor.min',
			//'jquery.cleditor.icon.min',
			//'jquery.cleditor.table.min',
			//'jquery.cleditor.imagebis',
			'zoombox',
			'cleanity'
		);

		parent::init();
	}
}