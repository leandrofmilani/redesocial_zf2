<?php

namespace DoctrineORMModule\Proxy\__CG__\Admin\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Usuario extends \Admin\Entity\Usuario implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'id', 'role', 'amigos', 'solicitacoes', 'inputFilter', 'nome', 'sobrenome', 'visibilidadePerfil', 'email', 'celular', 'profissao', 'localtrabalho', 'endereco', 'formacao', 'senha', 'dataNasc', 'sexo', 'relacionamento', 'posts', 'photo');
        }

        return array('__isInitialized__', 'id', 'role', 'amigos', 'solicitacoes', 'inputFilter', 'nome', 'sobrenome', 'visibilidadePerfil', 'email', 'celular', 'profissao', 'localtrabalho', 'endereco', 'formacao', 'senha', 'dataNasc', 'sexo', 'relacionamento', 'posts', 'photo');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Usuario $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getPosts()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPosts', array());

        return parent::getPosts();
    }

    /**
     * {@inheritDoc}
     */
    public function getAmigos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAmigos', array());

        return parent::getAmigos();
    }

    /**
     * {@inheritDoc}
     */
    public function getSolicitacoes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSolicitacoes', array());

        return parent::getSolicitacoes();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getRole()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRole', array());

        return parent::getRole();
    }

    /**
     * {@inheritDoc}
     */
    public function setRole($role)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRole', array($role));

        return parent::setRole($role);
    }

    /**
     * {@inheritDoc}
     */
    public function getNome()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNome', array());

        return parent::getNome();
    }

    /**
     * {@inheritDoc}
     */
    public function setNome($nome)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNome', array($nome));

        return parent::setNome($nome);
    }

    /**
     * {@inheritDoc}
     */
    public function getVisibilidadePerfil()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVisibilidadePerfil', array());

        return parent::getVisibilidadePerfil();
    }

    /**
     * {@inheritDoc}
     */
    public function setVisibilidadePerfil($visibilidadePerfil)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVisibilidadePerfil', array($visibilidadePerfil));

        return parent::setVisibilidadePerfil($visibilidadePerfil);
    }

    /**
     * {@inheritDoc}
     */
    public function getSobrenome()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSobrenome', array());

        return parent::getSobrenome();
    }

    /**
     * {@inheritDoc}
     */
    public function setSobrenome($sobrenome)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSobrenome', array($sobrenome));

        return parent::setSobrenome($sobrenome);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmail', array());

        return parent::getEmail();
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail($email)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmail', array($email));

        return parent::setEmail($email);
    }

    /**
     * {@inheritDoc}
     */
    public function getCelular()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCelular', array());

        return parent::getCelular();
    }

    /**
     * {@inheritDoc}
     */
    public function setCelular($celular)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCelular', array($celular));

        return parent::setCelular($celular);
    }

    /**
     * {@inheritDoc}
     */
    public function getProfissao()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProfissao', array());

        return parent::getProfissao();
    }

    /**
     * {@inheritDoc}
     */
    public function setProfissao($profissao)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProfissao', array($profissao));

        return parent::setProfissao($profissao);
    }

    /**
     * {@inheritDoc}
     */
    public function getLocaltrabalho()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLocaltrabalho', array());

        return parent::getLocaltrabalho();
    }

    /**
     * {@inheritDoc}
     */
    public function setLocaltrabalho($localtrabalho)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLocaltrabalho', array($localtrabalho));

        return parent::setLocaltrabalho($localtrabalho);
    }

    /**
     * {@inheritDoc}
     */
    public function getEndereco()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEndereco', array());

        return parent::getEndereco();
    }

    /**
     * {@inheritDoc}
     */
    public function setEndereco($endereco)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEndereco', array($endereco));

        return parent::setEndereco($endereco);
    }

    /**
     * {@inheritDoc}
     */
    public function getFormacao()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFormacao', array());

        return parent::getFormacao();
    }

    /**
     * {@inheritDoc}
     */
    public function setFormacao($formacao)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFormacao', array($formacao));

        return parent::setFormacao($formacao);
    }

    /**
     * {@inheritDoc}
     */
    public function getSenha()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSenha', array());

        return parent::getSenha();
    }

    /**
     * {@inheritDoc}
     */
    public function setSenha($senha)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSenha', array($senha));

        return parent::setSenha($senha);
    }

    /**
     * {@inheritDoc}
     */
    public function getDataNasc()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDataNasc', array());

        return parent::getDataNasc();
    }

    /**
     * {@inheritDoc}
     */
    public function setDataNasc($dataNasc)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDataNasc', array($dataNasc));

        return parent::setDataNasc($dataNasc);
    }

    /**
     * {@inheritDoc}
     */
    public function getSexo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSexo', array());

        return parent::getSexo();
    }

    /**
     * {@inheritDoc}
     */
    public function setSexo(\Admin\Entity\Sexo $sexo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSexo', array($sexo));

        return parent::setSexo($sexo);
    }

    /**
     * {@inheritDoc}
     */
    public function getRelacionamento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRelacionamento', array());

        return parent::getRelacionamento();
    }

    /**
     * {@inheritDoc}
     */
    public function setRelacionamento(\Admin\Entity\Relacionamento $relacionamento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRelacionamento', array($relacionamento));

        return parent::setRelacionamento($relacionamento);
    }

    /**
     * {@inheritDoc}
     */
    public function setPhoto($photo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPhoto', array($photo));

        return parent::setPhoto($photo);
    }

    /**
     * {@inheritDoc}
     */
    public function getPhoto()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPhoto', array());

        return parent::getPhoto();
    }

    /**
     * {@inheritDoc}
     */
    public function getArrayCopy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getArrayCopy', array());

        return parent::getArrayCopy();
    }

    /**
     * {@inheritDoc}
     */
    public function getInputFilter()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInputFilter', array());

        return parent::getInputFilter();
    }

}
