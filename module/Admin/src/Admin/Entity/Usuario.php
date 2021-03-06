<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * @ORM\Entity
 * @ORM\Table (name = "usuario")
 *
 * @author Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 * @category Admin
 * @package Entity
 */
class Usuario
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
    * @ORM\Column (type="string")
    *
    * @var string
    */
    protected $role;


   /**
     * @ORM\ManyToMany(targetEntity="\Admin\Entity\Usuario")
     *  * @ORM\JoinTable(name="usuario_amigos",
     *      joinColumns={@ORM\JoinColumn(name="id_amigo", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_usuario", referencedColumnName="id")}
     *      )
     *
     * @var \Admin\Entity\Usuario
     */
    protected $amigos;

    /**
     * @ORM\ManyToMany(targetEntity="\Admin\Entity\Usuario")
     *  * @ORM\JoinTable(name="usuario_solicitacao",
     *      joinColumns={@ORM\JoinColumn(name="id_amigo", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_usuario", referencedColumnName="id")}
     *      )
     *
     * @var \Admin\Entity\Usuario
     */
    protected $solicitacoes;
  
    protected $inputFilter;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $nome;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $sobrenome;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */

    protected $visibilidadePerfil;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */

    protected $email;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $celular;

    /**
     * @ORM\Column (type="string", nullable=true)
     *
     * @var string
     */
    protected $profissao;

    /**
     * @ORM\Column (type="string", nullable=true)
     *
     * @var string
     */
    protected $localtrabalho;

    /**
     * @ORM\Column (type="string", nullable=true)
     *
     * @var string
     */
    protected $endereco;

    /**
     * @ORM\Column (type="string", nullable=true)
     *
     * @var string
     */
    protected $formacao;


    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $senha;

    /**
     * @ORM\Column (type="datetime")
     *
     * @var datetime
     */
    protected $dataNasc;

    /**
     * @ORM\ManyToOne(targetEntity="\Admin\Entity\Sexo")
     * @ORM\JoinColumn(name="id_sexo", referencedColumnName="id")
     *
     * @var \Admin\Entity\Sexo
     */
    protected $sexo;

    /**
     * @ORM\ManyToOne(targetEntity="Relacionamento")
     * @ORM\JoinColumn(name="id_relacionamento", referencedColumnName="id")
     *
     * @var \Admin\Entity\Relacionamento
     */
    protected $relacionamento;

    /**
    *@ORM\OneToMany(targetEntity="Post", mappedBy="usuario")
    *
    */
    protected $posts;

    /**
     * @ORM\Column(type="blob", nullable=true)
     *
     * @var blob
     */
    protected $photo;

    public function __construct()
    {
    $this->amigos = new ArrayCollection();
    $this->solicitacoes = new ArrayCollection();
    $this->posts = new ArrayCollection();
    }

    public function getPosts()
    {
    return $this->posts;
    }

    /**
     * @return Usuario
     */
    public function getAmigos()
    {
        return $this->amigos;
    }

     /**
     * @return Usuario
     */
    public function getSolicitacoes()
    {
        return $this->solicitacoes;
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
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

     /**
     * @return string
     */
    public function getVisibilidadePerfil()
    {
        return $this->visibilidadePerfil;
    }

    /**
     * @param string $visibilidadePerfil
     */
    public function setVisibilidadePerfil($visibilidadePerfil)
    {
        $this->visibilidadePerfil = $visibilidadePerfil;
    }

    /**
     * @return string
     */
    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    /**
     * @param string $sobrenome
     */
    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @param string $celular
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    /**
     * @return string
     */
    public function getProfissao()
    {
        return $this->profissao;
    }

    /**
     * @param string $profissao
     */
    public function setProfissao($profissao)
    {
        $this->profissao = $profissao;
    }

    /**
     * @return string
     */
    public function getLocaltrabalho()
    {
        return $this->localtrabalho;
    }

    /**
     * @param string $localtrabalho
     */
    public function setLocaltrabalho($localtrabalho)
    {
        $this->localtrabalho = $localtrabalho;
    }

    /**
     * @return string
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param string $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     * @return string
     */
    public function getFormacao()
    {
        return $this->formacao;
    }

    /**
     * @param string $formacao
     */
    public function setFormacao($formacao)
    {
        $this->formacao = $formacao;
    }

    /**
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param string $senha
     */
    public function setSenha($senha)
    {
        $this->senha = md5($senha);
    }

    /**
     * @return datetime
     */
    public function getDataNasc()
    {
        $data = $this->dataNasc;
        return $data->format('Y-m-d');
    }

    /**
     * @param datetime $dataNasc
     */
    public function setDataNasc($dataNasc)
    {
        $this->dataNasc = $dataNasc;
    }

    /**
     * @return Sexo
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param Sexo $sexo
     */
    public function setSexo(\Admin\Entity\Sexo $sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * @return Relacionamento
     */
    public function getRelacionamento()
    {
        return $this->relacionamento;
    }

    /**
     * @param Relacionamento $relacionamento
     */
    public function setRelacionamento(\Admin\Entity\Relacionamento $relacionamento)
    {
        $this->relacionamento = $relacionamento;
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
                'name' => 'nome',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo Nome não pode estar vazio')
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
                'name' => 'sobrenome',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo Nome não pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo sobrenome deve ter mais que 3 caracteres e menos que 255',
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
                'name' => 'sexo',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo Sexo não pode estar vazio')
                    )
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'relacionamento',
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array('isEmpty' => 'O campo relacionamento nao pode estar vazio'),
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'email',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo E-mail não pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo E-mail deve ter mais que 3 caracteres e menos que 255',
                        ),
                    ),
                    array(
                        'name' => 'EmailAddress',
                        'options' => array('message' => 'NÃ£o parece ser um e-mail válido')
                    ),
                ),
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToLower',
                        'options' => array('encoding' => 'UTF-8')
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'dataNasc',
                'required' => true,
                'validators' => array (
                            array (
                                'name' => 'date',
                                'options' => array (
                                        'format' => "Y-m-d",
                                        'messages' => array(
                                            \Zend\Validator\Date::INVALID => 'Inválido.',
                                            \Zend\Validator\Date::INVALID_DATE => 'Data inválida.',
                                            \Zend\Validator\Date::FALSEFORMAT => 'Formato inválido.',
                                        ), 
                                        ) 
                                ) 
                            ) 
                )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'senha',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo Senha nÃ£o pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 8,
                            'max' => 20,
                            'message' => 'O campo senha deve ter mais que 8 caracteres e menos que 20',
                        ),
                    ),
                ),
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'celular',
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo celular não pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo celular deve ter mais que 3 caracteres e menos que 255',
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
                'name' => 'profissao',
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo profissao não pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo profissao deve ter mais que 3 caracteres e menos que 255',
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
                'name' => 'localtrabalho',
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo localtrabalho não pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo localtrabalho deve ter mais que 3 caracteres e menos que 255',
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
                'name' => 'endereco',
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo endereco não pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo endereco deve ter mais que 3 caracteres e menos que 255',
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
                'name' => 'formacao',
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo formacao não pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo formacao deve ter mais que 3 caracteres e menos que 255',
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
                'name' => 'role',
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo perfil não pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo perfil deve ter mais que 3 caracteres e menos que 255',
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