<?php

namespace Admin\Form;

use \Zend\Form\Form as Form;
use \Zend\Form\Element;

class Post extends Form
{

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct('post');
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
                'label' => 'Titulo:*'
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
            'name' => 'postComp',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Post Completo:*'
            ),
            'attributes' => array(
                'placeholder' => 'Digite o post Completo',
                'rows'=>'10',
                'class'=>'form-control',
                'id' => 'postComp'
            )
        ));

           $this->add(array(
            'name' => 'visibilidade',
            'type' => 'select',
            'options' => array(
                'label' => 'Visibilidade:*',
                'value_options' => array('publico' => 'PUBLICO', 'somenet amigos' => 'SOMENTE AMIGOS', 'somente eu' => 'SOMENTE EU' )
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'visibilidade'
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