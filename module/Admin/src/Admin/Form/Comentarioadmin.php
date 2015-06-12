<?php

namespace Admin\Form;

use \Zend\Form\Form as Form;
use \Zend\Form\Element;

class Comentarioadmin extends Form
{

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct('comentario');
        $this->setAttribute('action', '');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'name' => 'id',
                'type' => 'hidden',
            )
        );

         $this->add(array(
            'name' => 'id_post',
            'type' => 'text',
            'options' => array(
                'label' => 'Id do Post*'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o id do post',
                'id' => 'id_post'
            )
        ));        

         $this->add(array(
            'name' => 'comentario',
            'type' => 'text',
            'options' => array(
                'label' => 'Comentario:*'
            ),
            'attributes' => array(
                'placeholder' => 'Digite um Comentario',
                'id' => 'comentario'
            )
        ));

          $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Enviar'
            )
        ));

    }

}