<?php

class PageModel extends CoreModel {
	public $fields = array(
		'title' => array(
			'type' => 'text',
			'validate' => array(
				'max' => 255,
				'required' => true
			)
		),
		'content' => array(
			'type' => 'textarea',
			'validate' => array(
				'required' => true
			)
		)
	);

	public $many = array( 'comment' );

	public $belong = array( 'user' );

	public $one = array( 'date', 'status', 'order' );
}