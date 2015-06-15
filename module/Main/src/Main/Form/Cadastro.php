<?php

namespace Main\Form;

use \Zend\Form\Form as Form;
use \Zend\Form\Element;

class Cadastro extends Form
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
            'name' => 'sobrenome',
            'type' => 'text',
            'options' => array(
                'label' => 'Sobrenome:*'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o sobrenome',
                'id' => 'sobrenome'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'options' => array(
                'label' => 'Email'
            ),
            'attributes' => array(
                'placeholder' => 'seu@email.com.br',
                'id' => 'email'
            )
        ));

        $this->add(array(
            'name' => 'celular',
            'type' => 'text',
            'options' => array(
                'label' => 'Celular:*'
            ),
            'attributes' => array(
                'placeholder' => '88 8888-8888',
                'id' => 'celular'
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
            'type' => 'Zend\Form\Element\Date',
            'options' => array(
                'label' => 'Data Nasc:*'
            ),
            'attributes' => array(
                'placeholder' => 'Informe data',
                'id' => 'dataNasc'
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