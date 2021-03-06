<?php

namespace Admin\Form;

use \Zend\Form\Form as Form;
use \Zend\Form\Element;

class Perfil extends Form
{

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct('usuario');
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
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'options' => array(
                'label' => 'E-mail:*'
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
            'name' => 'endereco',
            'type' => 'text',
            'options' => array(
                'label' => 'Endereço: '
            ),
            'attributes' => array(
                'placeholder' => 'Ex.: Rua a, 123',
                'id' => 'endereco'
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
            'type' => 'DoctrineModule\Form\Element\ObjectRadio',
            'name' => 'relacionamento',
            'options' => array(
                'label' => 'Relacionamento:* ',
                'object_manager' => $em,
                'target_class' => 'Admin\Entity\Relacionamento',
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
            'name' => 'formacao',
            'type' => 'text',
            'options' => array(
                'label' => 'Formação: '
            ),
            'attributes' => array(
                'placeholder' => 'Ex.: Engenheiro Elétrico',
                'id' => 'formacao'
            )
        ));

        $this->add(array(
            'name' => 'profissao',
            'type' => 'text',
            'options' => array(
                'label' => 'Profissão: '
            ),
            'attributes' => array(
                'placeholder' => 'Ex.: Eletricista',
                'id' => 'profissao'
            )
        ));

        $this->add(array(
            'name' => 'localtrabalho',
            'type' => 'text',
            'options' => array(
                'label' => 'Local de Trabalho: '
            ),
            'attributes' => array(
                'placeholder' => 'Ex.: Celesc',
                'id' => 'localtrabalho'
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
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Salvar'
            )
        ));

    }

}