<?php

namespace Admin\Form;

use \Zend\Form\Form as Form;
use \Zend\Form\Element;

class Album extends Form
{

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct('album');
        $this->setAttribute('action', '');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(
            array(
                'name' => 'id',
                'type' => 'hidden',
            )
        );

        $this->add(array(
            'name' => 'titulo',
            'type' => 'text',
            'options' => array(
                'label' => 'Título:*'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o titulo',
                'id' => 'titulo'
            )
        ));

        $this->add(array(
            'name' => 'visibilidade',
            'type' => 'select',
            'options' => array(
                'label' => 'Visibilidade:*',
                'value_options' => array('publico' => 'PUBLICO', 'somente amigos' => 'SOMENTE AMIGOS', 'somente eu' => 'SOMENTE EU')
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'photo',
            'type' => 'file',
            'options' => array(
                'label' => 'Foto',
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