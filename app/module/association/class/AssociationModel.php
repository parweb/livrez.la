<?php

class AssociationModel extends CoreModel {
	public $fields = array(
		'module' => array(
			'type' => 'text',
			'validate' => array(
				'max' => 255,
				'required' => true
			)
		),
		'module_id' => array(
			'type' => 'numeric',
			'validate' => array(
				'required' => true
			)
		),
		'type' => array(
			'type' => 'text',
			'validate' => array(
				'max' => 255,
				'required' => true
			)
		),
		'behavior' => array(
			'type' => 'text',
			'validate' => array(
				'max' => 255,
				'required' => true
			)
		),
		'behavior_id' => array(
			'type' => 'numeric',
			'validate' => array(
				'required' => true
			)
		)
	);
}