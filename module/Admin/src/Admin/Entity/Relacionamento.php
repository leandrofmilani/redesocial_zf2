<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * @ORM\Entity
 * @ORM\Table (name = "relacionamento")
 *
 * @author Josemar Fuzinatto <josemarfuzinatto@unochapeco.edu.br>
 * @category Admin
 * @package Entity
 */
class Relacionamento
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $id;

	/**
	*
	*@var Zend/InputFilter/InputFilter
	*/
	protected $inputFilter;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $desc_relacionamento;

    /**
     * @return string
     */
    public function getDescRelacionamento()
    {
        return $this->desc_relacionamento;
    }

    /**
     * @param string $desc_interesse
     */
    public function setDescRelacionamento($desc_relacionamento)
    {
        $this->desc_relacionamento = $desc_relacionamento;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     /*
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
                'name' => 'desc_interesse',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo DescriÃ§Ã£o interesse nÃ£o pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo descriÃ§Ã£o interesse deve ter mais que 3 caracteres e menos que 255',
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
          
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }*/
}

?>