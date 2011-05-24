<?php

class UserModel extends CoreModel {
	public $fields = array(
		'login' => array(
			'type' => 'text',
			'validate' => array(
				'max' => 255,
				'required' => true
			)
		),
		'pass' => array(
			'type' => 'text',
			'validate' => array(
				'max' => 40,
			)
		),
		'sessioncode' => array(
			'type' => 'text',
			'validate' => array(
				'max' => 40,
			)
		),
		'email' => array(
			'type' => 'text',
			'validate' => array(
				'max' => 255,
			)
		)
	);

	public $one = array( 'date', 'status' );

	public $display = 'login';
}