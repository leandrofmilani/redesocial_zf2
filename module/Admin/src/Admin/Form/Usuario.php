<?php

namespace Admin\Form;

use \Zend\Form\Form as Form;
use \Zend\Form\Element;

class Usuario extends Form
{

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct('usuario');
        $this->setAttribute('action', '');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'name' => 'id',
                'type' => 'hidden',
            )
        );

        $this->add(array(
            'name' => 'nome',
            'type' => 'text',
            'options' => array(
                'label' => 'Nome:*'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o nome',
                'id' => 'nome'
            )
        ));


        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'options' => array(
                'label' => 'E-mail:*'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o e-mail',
                'id' => 'email'
            )
        ));

        $this->add(array(
            'name' => 'senha',
            'type' => 'password',
            'options' => array(
                'label' => 'Senha:*'
            ),
            'attributes' => array(
                'placeholder' => 'Informe senha',
                'id' => 'senha'
            )
        ));

         $this->add(array(
            'name' => 'dataNasc',
            'type' => 'date',
            'options' => array(
                'label' => 'Data Nasc:*'
            ),
            'attributes' => array(
                'placeholder' => 'Informe data',
                'id' => 'dataNasc'
            )
        ));

         $this->add(array(
            'name' => 'role',
            'type' => 'select',
            'options' => array(
                'label' => 'Perfil:*',
                'value_options' => array('EDITOR' => 'EDITOR', 'ADMIN' => 'ADMIN')
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectRadio',
            'name' => 'sexo',
            'options' => array(
                'label' => 'Sexo:*',
                'object_manager' => $em,
                'target_class' => 'Admin\Entity\Sexo',
                'property' => 'descricao',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('descricao' => 'ASC'),
                    ),
                ),
            ),
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