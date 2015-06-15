<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * @ORM\Entity
 * @ORM\Table (name = "album")
 *
 * @author Leandro Fabris Milani <lfm@unochapeco.edu.br>
 * @category Admin
 * @package Entity
 */
class Album
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
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $visibilidade;

     /**
     * @ORM\Column (type="datetime")
     *
     * @var datetime
     */
    protected $dataAlbum;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $usuario;

    /**
     * @ORM\Column(type="blob", nullable=true)
     *
     * @var blob
     */
    protected $photo;
    
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
     * @return string
     */
    public function getVisibilidade()
    {
        return $this->visibilidade;
    }

    /**
     * @param string $visibilidadePerfil
     */
    public function setVisibilidade($visibilidade)
    {
        $this->visibilidade = $visibilidade;
    }

    /**
     * @return datetime
     */
    public function getDataAlbum()
    {
        $data = $this->dataDataAlbum;
        return $data->format('Y-m-d H:i');
    }

    /**
     * @param datetime $dataAlbum
     */
    public function setDataAlbum($dataAlbum)
    {
        $this->dataAlbum = $dataAlbum;
    }


    /**
     * @param Usuario $usuario
     */
    public function setUsuario($usuario)
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
     * @param blob $photo
     *
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return blob
     */
    public function getPhoto()
    {
        return $this->photo;
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
                'name' => 'titulo',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo titulo não pode estar vazio')
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
                'name' => 'visibilidade',
                'required' => false
                )

            ));

            $inputFilter->add($factory->createInput(array(
                'name' => 'photo',
                'required' => false
                )

            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

?>