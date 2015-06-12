<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * @ORM\Entity
 * @ORM\Table (name = "comentario")
 *
 * @author Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 * @category Admin
 * @package Entity
 */
class Comentario
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
     * @ORM\Column (type="text")
     *
     * @var text
     */
    protected $comentario;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     * 
     * @var \Admin\Entity\Usuario
     */
    protected $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="\Admin\Entity\Post")
     * @ORM\JoinColumn(name="id_post", referencedColumnName="id")
     * 
     * @var \Admin\Entity\Post
     */
    protected $post;

     /**
     * @ORM\ManyToOne(targetEntity="\Admin\Entity\Evento")
     * @ORM\JoinColumn(name="id_evento", referencedColumnName="id")
     * 
     * @var \Admin\Entity\Evento
     */
    protected $evento;

     /**
     * @ORM\Column (type="datetime")
     *
     * @var datetime
     */
    protected $dataComentario;
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Usuario $usuario
     */
    public function setUsuario(\Admin\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @return text
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param text $comentario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }

    /**
     * @param $evento
     */
    public function setEvento(\Admin\Entity\Evento $evento)
    {
        $this->evento = $evento;
    }

    /**
     * @return Evento
     */
    public function getEvento()
    {
        return $this->evento;
    }

    /**
     * @param $post
     */
    public function setPost(\Admin\Entity\Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

     /**
     * @return datetime
     */
    public function getDataComentario()
    {
         $data = $this->dataComentario;
        return $data->format('Y-m-d H:i');
    }

    /**
     * @param datetime $dataComentario
     */
    public function setDataComentario($dataComentario)
    {
        $this->dataComentario = $dataComentario;
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
                'name' => 'comentario',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo Nome nÃ£o pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo nome deve ter mais que 3 caracteres e menos que 255',
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

         return $this->inputFilter;

        }


       

}

?>