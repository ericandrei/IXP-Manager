<?php

namespace Proxies\__CG__\Entities;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class PeeringManager extends \Entities\PeeringManager implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'email_last_sent', 'emails_sent', 'peered', 'rejected', 'notes', 'id', 'Customer', 'Peer', 'created', 'updated');
        }

        return array('__isInitialized__', 'email_last_sent', 'emails_sent', 'peered', 'rejected', 'notes', 'id', 'Customer', 'Peer', 'created', 'updated');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (PeeringManager $proxy) {
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
    public function setEmailLastSent($emailLastSent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmailLastSent', array($emailLastSent));

        return parent::setEmailLastSent($emailLastSent);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmailLastSent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmailLastSent', array());

        return parent::getEmailLastSent();
    }

    /**
     * {@inheritDoc}
     */
    public function setEmailsSent($emailsSent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmailsSent', array($emailsSent));

        return parent::setEmailsSent($emailsSent);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmailsSent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmailsSent', array());

        return parent::getEmailsSent();
    }

    /**
     * {@inheritDoc}
     */
    public function setPeered($peered)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPeered', array($peered));

        return parent::setPeered($peered);
    }

    /**
     * {@inheritDoc}
     */
    public function getPeered()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPeered', array());

        return parent::getPeered();
    }

    /**
     * {@inheritDoc}
     */
    public function setRejected($rejected)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRejected', array($rejected));

        return parent::setRejected($rejected);
    }

    /**
     * {@inheritDoc}
     */
    public function getRejected()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRejected', array());

        return parent::getRejected();
    }

    /**
     * {@inheritDoc}
     */
    public function setNotes($notes)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNotes', array($notes));

        return parent::setNotes($notes);
    }

    /**
     * {@inheritDoc}
     */
    public function getNotes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNotes', array());

        return parent::getNotes();
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
    public function setCustomer(\Entities\Customer $customer = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCustomer', array($customer));

        return parent::setCustomer($customer);
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomer()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCustomer', array());

        return parent::getCustomer();
    }

    /**
     * {@inheritDoc}
     */
    public function setPeer(\Entities\Customer $peer = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPeer', array($peer));

        return parent::setPeer($peer);
    }

    /**
     * {@inheritDoc}
     */
    public function getPeer()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPeer', array());

        return parent::getPeer();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreated($created)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreated', array($created));

        return parent::setCreated($created);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreated()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreated', array());

        return parent::getCreated();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdated($updated)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdated', array($updated));

        return parent::setUpdated($updated);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdated()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdated', array());

        return parent::getUpdated();
    }

}
