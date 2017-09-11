<?php

namespace DoctrineORMModule\Proxy\__CG__\Projeto\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Nucleo extends \Projeto\Entity\Nucleo implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'id', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'projeto', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'nome', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'telefone', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'email', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'coorporativo', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'descricao', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'slug', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'texto', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'posicao', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'created_at', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'data_cancelamento', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'imagem', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'status', 'nucleo_usuario', 'nucleo_documento');
        }

        return array('__isInitialized__', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'id', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'projeto', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'nome', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'telefone', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'email', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'coorporativo', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'descricao', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'slug', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'texto', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'posicao', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'created_at', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'data_cancelamento', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'imagem', '' . "\0" . 'Projeto\\Entity\\Nucleo' . "\0" . 'status', 'nucleo_usuario', 'nucleo_documento');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Nucleo $proxy) {
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
    public function getCoorporativo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCoorporativo', array());

        return parent::getCoorporativo();
    }

    /**
     * {@inheritDoc}
     */
    public function setCoorporativo($coorporativo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCoorporativo', array($coorporativo));

        return parent::setCoorporativo($coorporativo);
    }

    /**
     * {@inheritDoc}
     */
    public function addNucleoUsuario(\Usuario\Entity\NucleoUsuario $NucleoUsuario)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addNucleoUsuario', array($NucleoUsuario));

        return parent::addNucleoUsuario($NucleoUsuario);
    }

    /**
     * {@inheritDoc}
     */
    public function removeNucleoUsuario(\Usuario\Entity\NucleoUsuario $NucleoUsuario)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeNucleoUsuario', array($NucleoUsuario));

        return parent::removeNucleoUsuario($NucleoUsuario);
    }

    /**
     * {@inheritDoc}
     */
    public function getNucleoUsuario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNucleoUsuario', array());

        return parent::getNucleoUsuario();
    }

    /**
     * {@inheritDoc}
     */
    public function addNucleoDocumento(\Usuario\Entity\NucleoDocumento $NucleoDocumento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addNucleoDocumento', array($NucleoDocumento));

        return parent::addNucleoDocumento($NucleoDocumento);
    }

    /**
     * {@inheritDoc}
     */
    public function removeNucleoDocumento(\Usuario\Entity\NucleoDocumento $NucleoDocumento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeNucleoDocumento', array($NucleoDocumento));

        return parent::removeNucleoDocumento($NucleoDocumento);
    }

    /**
     * {@inheritDoc}
     */
    public function getNucleoDocumento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNucleoDocumento', array());

        return parent::getNucleoDocumento();
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', array());

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', array($status));

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function getProjeto()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProjeto', array());

        return parent::getProjeto();
    }

    /**
     * {@inheritDoc}
     */
    public function setProjeto($projeto)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProjeto', array($projeto));

        return parent::setProjeto($projeto);
    }

    /**
     * {@inheritDoc}
     */
    public function getTelefone()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTelefone', array());

        return parent::getTelefone();
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
    public function setTelefone($telefone)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTelefone', array($telefone));

        return parent::setTelefone($telefone);
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
    public function setNome($nome)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNome', array($nome));

        return parent::setNome($nome);
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
    public function getDescricao()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescricao', array());

        return parent::getDescricao();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescricao($descricao)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescricao', array($descricao));

        return parent::setDescricao($descricao);
    }

    /**
     * {@inheritDoc}
     */
    public function getTexto()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTexto', array());

        return parent::getTexto();
    }

    /**
     * {@inheritDoc}
     */
    public function setTexto($texto)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTexto', array($texto));

        return parent::setTexto($texto);
    }

    /**
     * {@inheritDoc}
     */
    public function getPosicao()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPosicao', array());

        return parent::getPosicao();
    }

    /**
     * {@inheritDoc}
     */
    public function setPosicao($posicao)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPosicao', array($posicao));

        return parent::setPosicao($posicao);
    }

    /**
     * {@inheritDoc}
     */
    public function getSlug()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSlug', array());

        return parent::getSlug();
    }

    /**
     * {@inheritDoc}
     */
    public function setSlug($slug)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSlug', array($slug));

        return parent::setSlug($slug);
    }

    /**
     * {@inheritDoc}
     */
    public function getImagem()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImagem', array());

        return parent::getImagem();
    }

    /**
     * {@inheritDoc}
     */
    public function setImagem($imagem)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImagem', array($imagem));

        return parent::setImagem($imagem);
    }

    /**
     * {@inheritDoc}
     */
    public function setDataCancelamento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDataCancelamento', array());

        return parent::setDataCancelamento();
    }

}
