<?php

namespace Proxies\__CG__\Entities;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class IXP extends \Entities\IXP implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'name', 'shortname', 'address1', 'address2', 'address3', 'address4', 'country', 'id', 'Infrastructures', '' . "\0" . 'Entities\\IXP' . "\0" . 'Customers', '' . "\0" . 'Entities\\IXP' . "\0" . 'mrtg_path', '' . "\0" . 'Entities\\IXP' . "\0" . 'mrtg_p2p_path', '' . "\0" . 'Entities\\IXP' . "\0" . 'TrafficDaily', '' . "\0" . 'Entities\\IXP' . "\0" . 'aggregate_graph_name', '' . "\0" . 'Entities\\IXP' . "\0" . 'smokeping');
        }

        return array('__isInitialized__', 'name', 'shortname', 'address1', 'address2', 'address3', 'address4', 'country', 'id', 'Infrastructures', '' . "\0" . 'Entities\\IXP' . "\0" . 'Customers', '' . "\0" . 'Entities\\IXP' . "\0" . 'mrtg_path', '' . "\0" . 'Entities\\IXP' . "\0" . 'mrtg_p2p_path', '' . "\0" . 'Entities\\IXP' . "\0" . 'TrafficDaily', '' . "\0" . 'Entities\\IXP' . "\0" . 'aggregate_graph_name', '' . "\0" . 'Entities\\IXP' . "\0" . 'smokeping');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (IXP $proxy) {
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
    public function setName($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', array($name));

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', array());

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setShortname($shortname)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setShortname', array($shortname));

        return parent::setShortname($shortname);
    }

    /**
     * {@inheritDoc}
     */
    public function getShortname()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getShortname', array());

        return parent::getShortname();
    }

    /**
     * {@inheritDoc}
     */
    public function setAddress1($address1)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAddress1', array($address1));

        return parent::setAddress1($address1);
    }

    /**
     * {@inheritDoc}
     */
    public function getAddress1()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAddress1', array());

        return parent::getAddress1();
    }

    /**
     * {@inheritDoc}
     */
    public function setAddress2($address2)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAddress2', array($address2));

        return parent::setAddress2($address2);
    }

    /**
     * {@inheritDoc}
     */
    public function getAddress2()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAddress2', array());

        return parent::getAddress2();
    }

    /**
     * {@inheritDoc}
     */
    public function setAddress3($address3)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAddress3', array($address3));

        return parent::setAddress3($address3);
    }

    /**
     * {@inheritDoc}
     */
    public function getAddress3()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAddress3', array());

        return parent::getAddress3();
    }

    /**
     * {@inheritDoc}
     */
    public function setAddress4($address4)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAddress4', array($address4));

        return parent::setAddress4($address4);
    }

    /**
     * {@inheritDoc}
     */
    public function getAddress4()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAddress4', array());

        return parent::getAddress4();
    }

    /**
     * {@inheritDoc}
     */
    public function setCountry($country)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCountry', array($country));

        return parent::setCountry($country);
    }

    /**
     * {@inheritDoc}
     */
    public function getCountry()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCountry', array());

        return parent::getCountry();
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
    public function addInfrastructure(\Entities\Infrastructure $infrastructures)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addInfrastructure', array($infrastructures));

        return parent::addInfrastructure($infrastructures);
    }

    /**
     * {@inheritDoc}
     */
    public function removeInfrastructure(\Entities\Infrastructure $infrastructures)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeInfrastructure', array($infrastructures));

        return parent::removeInfrastructure($infrastructures);
    }

    /**
     * {@inheritDoc}
     */
    public function getInfrastructures()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInfrastructures', array());

        return parent::getInfrastructures();
    }

    /**
     * {@inheritDoc}
     */
    public function addCustomer(\Entities\Customer $customers)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCustomer', array($customers));

        return parent::addCustomer($customers);
    }

    /**
     * {@inheritDoc}
     */
    public function removeCustomer(\Entities\Customer $customers)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeCustomer', array($customers));

        return parent::removeCustomer($customers);
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomers()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCustomers', array());

        return parent::getCustomers();
    }

    /**
     * {@inheritDoc}
     */
    public function setMrtgPath($mrtgPath)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMrtgPath', array($mrtgPath));

        return parent::setMrtgPath($mrtgPath);
    }

    /**
     * {@inheritDoc}
     */
    public function getMrtgPath()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMrtgPath', array());

        return parent::getMrtgPath();
    }

    /**
     * {@inheritDoc}
     */
    public function setMrtgP2pPath($mrtgP2pPath)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMrtgP2pPath', array($mrtgP2pPath));

        return parent::setMrtgP2pPath($mrtgP2pPath);
    }

    /**
     * {@inheritDoc}
     */
    public function getMrtgP2pPath()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMrtgP2pPath', array());

        return parent::getMrtgP2pPath();
    }

    /**
     * {@inheritDoc}
     */
    public function addTrafficDaily(\Entities\TrafficDaily $trafficDaily)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addTrafficDaily', array($trafficDaily));

        return parent::addTrafficDaily($trafficDaily);
    }

    /**
     * {@inheritDoc}
     */
    public function removeTrafficDaily(\Entities\TrafficDaily $trafficDaily)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeTrafficDaily', array($trafficDaily));

        return parent::removeTrafficDaily($trafficDaily);
    }

    /**
     * {@inheritDoc}
     */
    public function getTrafficDaily()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTrafficDaily', array());

        return parent::getTrafficDaily();
    }

    /**
     * {@inheritDoc}
     */
    public function setAggregateGraphName($aggregateGraphName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAggregateGraphName', array($aggregateGraphName));

        return parent::setAggregateGraphName($aggregateGraphName);
    }

    /**
     * {@inheritDoc}
     */
    public function getAggregateGraphName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAggregateGraphName', array());

        return parent::getAggregateGraphName();
    }

    /**
     * {@inheritDoc}
     */
    public function setSmokeping($smokeping)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSmokeping', array($smokeping));

        return parent::setSmokeping($smokeping);
    }

    /**
     * {@inheritDoc}
     */
    public function getSmokeping()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSmokeping', array());

        return parent::getSmokeping();
    }

}
