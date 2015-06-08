<?php

namespace Admin\Form;

use \Zend\Form\Form as Form;
use \Zend\Form\Element;

class Evento extends Form
{

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct('post');
        $this->setAttribute('action', '');
        $this->setAttribute('method', 'post');

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
                'label' => 'Titulo do Evento:*'
            ),
            'attributes' => array(
                'placeholder'=>'Por favor, insira um titulo.',
                'id' => 'titulo',
            )
        ));

         $this->add(array(
            'name' => 'minText',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Mini Texto:*'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o mini texto',
                'rows'=>'2',
                'class'=>'form-control',
                'id' => 'minText'
            )
        ));

          $this->add(array(
            'name' => 'eventoComp',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Evento Completo:*'
            ),
            'attributes' => array(
                'placeholder' => 'Digite o Evento Completo',
                'rows'=>'10',
                'class'=>'form-control',
                'id' => 'eventoComp'
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