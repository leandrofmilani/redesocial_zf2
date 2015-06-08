<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * @ORM\Entity
 * @ORM\Table (name = "evento")
 *
 * @author Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 * @category Admin
 * @package Entity
 */
class Evento
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $id;


    protected $inputFilter;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $titulo;

    /**
     * @ORM\Column (type="text")
     *
     * @var text
     */
    protected $minText;

    /**
     * @ORM\Column (type="text")
     *
     * @var text
     */
    protected $eventoComp;

     /**
     * @ORM\Column (type="datetime")
     *
     * @var datetime
     */
    protected $dataEvento;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     * 
     * @var \Admin\Entity\Usuario
     */
    protected $usuario;

    /**
    *@ORM\OneToMany(targetEntity="Comentario", mappedBy="post")
    *
    */
    protected $comentarios;

    public function __construct()
    {
	$this->comentarios = new ArrayCollection();
    }

    public function getComentarios()
    {
	return $this->comentarios;
    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }    
    
    /**
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return text
     */
    public function getMintext()
    {
        return $this->minText;
    }

    /**
     * @param text $minText
     */
    public function setMinText($minText)
    {
        $this->minText = $minText;
    }

    /**
     * @return text
     */
    public function getEventoComp()
    {
        return $this->eventoComp;
    }

    /**
     * @param text $eventoComp
     */
    public function setEventoComp($eventoComp)
    {
        $this->eventoComp = $eventoComp;
    }


    /**
     * @return datetime
     */
    public function getDataEvento()
    {
        $data = $this->dataEvento;
        return $data->format('Y-m-d H:i');
    }

    /**
     * @param datetime $dataEvento
     */
    public function setDataEvento($dataEvento)
    {
        $this->dataEvento = $dataEvento;
    }


    /**
     * @param Usuario $usuario
     */
    public function setUsuario(\Admin\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    }


    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     *
     * @return Zend/InputFilter/InputFilter
     */
    public function getInputFilter(){

        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => false,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'ativo',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int',
                         'options' => array('message' => 'O campo Ativo nÃ£o pode estar vazio')
                         ),
                ),
            )));
            

            $inputFilter->add($factory->createInput(array(
                'name' => 'titulo',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo titulo nÃ£o pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo titulo deve ter mais que 3 caracteres e menos que 255',
                        ),
                    ),
                ),
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToUpper',
                        'options' => array('encoding' => 'UTF-8')
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'minText',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo minText nÃ£o pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo minText deve ter mais que 3 caracteres e menos que 255',
                        ),
                    ),
                ),
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToUpper',
                        'options' => array('encoding' => 'UTF-8')
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'postComp',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo postComp nÃ£o pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo postComp deve ter mais que 3 caracteres e menos que 255',
                        ),
                    ),
                ),
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToUpper',
                        'options' => array('encoding' => 'UTF-8')
                    ),
                ),
            )));

           /* $inputFilter->add($factory->createInput(array(
                'name' => 'dataPost',
                'required' => true,
                'validators' => array (
                            array (
                                'name' => 'Date',
                                'options' => array (
                                        'format' => "d/m/Y",
                                        'messages' => array(
                                            \Zend\Validator\Date::INVALID => 'Inválido.',
                                            \Zend\Validator\Date::INVALID_DATE => 'Data inválida.',
                                            \Zend\Validator\Date::FALSEFORMAT => 'Formato inválido.',
                                        ), 
                                        ) 
                                ) 
                            ) 
                )));*/


        return $this->inputFilter;
    }
  }
}

?>
