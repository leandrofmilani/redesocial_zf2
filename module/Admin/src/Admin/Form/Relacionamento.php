<?php

namespace Admin\Form;

use \Zend\Form\Form as Form;
use \Zend\Form\Element;

class Relacionamento extends Form
{

	public function __construct()
	{
		parent::__construct('relacionamento');
		$this->setAttribute('action', '');
		$this->setAttribute('method','post');

		$this->add(array(
			'name' => 'id',
			'type' => 'hidden',
		));

		$this->add(array(
			'name' => 'desc_relacionamento',
			'type' => 'text',
			'options' => array(
				'label' => 'Descricao:'
			),
			'attributes' => array(
				'placeholder' => 'Informe a descricao',
				'id' => 'desc_relacionamento'
			)
		));

		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Salvar'
			)
		));
	}
}
?>