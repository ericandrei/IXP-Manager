<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;
use Entities\CoreBundle;
use Entities\SwitchPort;

/**
 * Switcher
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Switcher extends EntityRepository
{
    /**
     * The cache key for all switch objects
     * @var string The cache key for all switch objects
     */
    const ALL_CACHE_KEY = 'inex_switches';

    /**
     * Return an array of all switch objects from the database with caching
     *
     * @param bool $active If `true`, return only active switches
     * @param int $type If `0`, all types otherwise limit to specific type
     * @return array An array of all switch objects
     */
    public function getAndCache( $active = false, $type = 0 )
    {
        $dql = "SELECT s FROM Entities\\Switcher s WHERE 1=1";

        $key = $this->genCacheKey( $active, $type );

        if( $active )
            $dql .= " AND s.active = 1";

        if( $type )
            $dql .= " AND s.switchtype = " . intval( $type );

        return $this->getEntityManager()->createQuery( $dql )
            ->useResultCache( true, 3600, $key )
            ->getResult();
    }


    /**
     * Clear the cache of a given result set
     *
     * @param bool $active If `true`, return only active switches
     * @param int $type If `0`, all types otherwise limit to specific type
     */
    public function clearCache( $active = false, $type = 0 )
    {
        return $this->getEntityManager()->getConfiguration()->getQueryCacheImpl()->delete(
            $this->genCacheKey( $active, $type )
        );
    }

    /**
     * Clear the cache of all result sets
     */
    public function clearCacheAll()
    {
        foreach( [ true, false ] as $active ) {
            foreach( \Entities\Switcher::$TYPES as $type => $name ) {
                $this->getEntityManager()->getConfiguration()->getQueryCacheImpl()->delete(
                    $this->genCacheKey( $active, $type )
                );
            }
        }
    }

    /**
     * Generate a deterministic caching key for given parameters
     *
     * @param bool $active If `true`, return only active switches
     * @param int $type If `0`, all types otherwise limit to specific type
     * @return string The generate caching key
     */
    public function genCacheKey( $active, $type )
    {
        $key = self::ALL_CACHE_KEY;

        if( $active )
            $key .= '-active';
        else
            $key .= '-all';

        if( $type )
            $key .= '-' . intval( $type );
        else
            $key .= '-all';

        return $key;
    }

    /**
     * Return an array of all switch names where the array key is the switch id
     *
     * @param bool          $active If `true`, return only active switches
     * @param int           $type   If `0`, all types otherwise limit to specific type
     * @param \Entities\IXP $ixp    IXP to filter vlan names
     * @return array An array of all switch names with the switch id as the key.
     */
    public function getNames( $active = false, $type = 0, $ixp = false )
    {
        $switches = [];
        foreach( $this->getAndCache( $active, $type ) as $a )
        {
            if( !$ixp || ( $ixp->getInfrastructures()->contains( $a->getInfrastructure() ) ) )
                $switches[ $a->getId() ] = $a->getName();
        }

        asort( $switches );
        return $switches;
    }

    /**
     * Return an array of all switch names where the array key is the switch id
     *
     * @param bool          $active If `true`, return only active switches
     * @param int           $type   If `0`, all types otherwise limit to specific type
     * @param int           $idLocation  location requiered
     * @return array An array of all switch names with the switch id as the key.
     */
    public function getNamesByLocation( $active = false, $type = 0, $idLocation = null )
    {
        $switches = [];
        foreach( $this->getAndCache( $active, $type ) as $a ) {

            if($idLocation != null)
                if($a->getCabinet()->getLocation()->getId() == $idLocation)
                    $switches[ $a->getId() ] = $a->getName();
        }

        asort( $switches );
        return $switches;
    }


    /**
     * Return an array of configurations
     *
     * @param int $switchid Switcher id for filtering results
     * @param int $vlanid   Vlan id for filtering results
     * @param int $ixpid    IXP id for filtering results
     * @return array
     */
    public function getConfiguration( $switchid = null, $vlanid = null, $ixpid = null, $superuser = true )
    {
        $q =
            "SELECT s.name AS switchname, s.id AS switchid,
                    sp.name AS portname, sp.ifName AS ifName,
                    pi.speed AS speed, pi.duplex AS duplex, pi.status AS portstatus,
                    c.name AS customer, c.id AS custid, c.autsys AS asn,
                    vli.rsclient AS rsclient,
                    v.name AS vlan,
                    ipv4.address AS ipv4address, ipv6.address AS ipv6address

            FROM \\Entities\\VlanInterface vli
                JOIN vli.IPv4Address ipv4
                LEFT JOIN vli.IPv6Address ipv6
                LEFT JOIN vli.Vlan v
                LEFT JOIN vli.VirtualInterface vi
                LEFT JOIN vi.Customer c
                LEFT JOIN vi.PhysicalInterfaces pi
                LEFT JOIN pi.SwitchPort sp
                LEFT JOIN sp.Switcher s
                LEFT JOIN v.Infrastructure vinf
                LEFT JOIN vinf.IXP vixp
                LEFT JOIN s.Infrastructure sinf
                LEFT JOIN sinf.IXP sixp

            WHERE 1=1 ";

        if( $switchid !== null )
            $q .= 'AND s.id = ' . intval( $switchid ) . ' ';

        if( $vlanid !== null )
            $q .= 'AND v.id = ' . intval( $vlanid ) . ' ';

        if( $ixpid !== null )
            $q .= 'AND ( sixp.id = ' . intval( $ixpid ) . ' OR vixp.id = ' . intval( $ixpid ) . ' ) ';

        if( !$superuser && $ixpid )
            $q .= 'AND ?1 MEMBER OF c.IXPs ';

        $q .= "ORDER BY customer ASC";

        $query = $this->getEntityManager()->createQuery( $q );

        if( !$superuser && $ixpid )
            $query->setParameter( 1, $ixpid );
        
        return $query->getArrayResult();
    }


    /**
     * Get all active switches as Doctrine2 objects
     *
     * @return array
     */
    public function getActive()
    {
        $q = "SELECT s FROM \\Entities\\Switcher s WHERE s.active = 1";
        return $this->getEntityManager()->createQuery( $q )->getResult();
    }

    /**
     * Returns all switch ports for a given switch.
     *
     * Each switchport element of the array is as follows:
     *
     *      [
     *          "sp_type" => 5,
     *          "sp_name" => "Management Port",
     *          "sp_active" => true,
     *          "sp_ifIndex" => 1059,
     *          "sp_ifName" => "Management",
     *          "sp_ifAlias" => "MgmtPort",
     *          "sp_ifHighSpeed" => 1000,
     *          "sp_ifMtu" => 1500,
     *          "sp_ifPhysAddress" => "0004968F9A4F",
     *          "sp_ifAdminStatus" => 1,
     *          "sp_ifOperStatus" => 1,
     *          "sp_ifLastChange" => 1473091000,
     *          "sp_lastSnmpPoll" => DateTime {#1382
     *          +"date": "2016-10-26 15:11:31.000000",
     *              +"timezone_type": 3,
     *              +"timezone": "UTC",
     *          },
     *          "sp_lagIfIndex" => null,
     *          "sp_mauType" => "1000BaseTFD",
     *          "sp_mauState" => "operational",
     *          "sp_mauAvailability" => "available",
     *          "sp_mauJacktype" => "rj45S",
     *          "sp_mauAutoNegSupported" => true,
     *          "sp_mauAutoNegAdminState" => true,
     *          "sp_id" => 1525,
     *          "pi_id" => null,
     *          "sp_switchid" => 35,
     *          "sp_type_name" => "Management",
     *          ],
     *
     * @param int      $id     Switch ID - switch to query
     * @return array
     */
    public function getPorts( int $id ): array {

        $dql = "SELECT sp, pi.id AS pi_id
                    FROM Entities\\SwitchPort sp
                      LEFT JOIN sp.Switcher s
                      LEFT JOIN sp.PhysicalInterface pi
                    WHERE s.id = ?1
                    ORDER BY sp.id ASC";

        $ports = $this->getEntityManager()->createQuery( $dql )
                    ->setParameter( 1, $id )
                    ->setHint(\Doctrine\ORM\Query::HINT_INCLUDE_META_COLUMNS, true)
                    ->getScalarResult();

        foreach( $ports as $id => $port )
            $ports[$id]['sp_type_name'] = \Entities\SwitchPort::$TYPES[ $port['sp_type'] ];

        return $ports;
    }

    /**
     * Returns all available switch ports where available means not in use by a
     * patch panel port.
     *
     * Function specifically for use with the patch panel ports functionality.
     *
     * Not suitable for other generic use.
     *
     * @param int      $id     Switch ID - switch to query
     * @param int|null $cid    Customer ID, if set limit to a customer's ports
     * @param int|null $spid   Switch port ID, if set, this port is excluded from the results
     * @return array
     */
    public function getAllPortsForPPP( int $id, int $cid = null, int $spid = null ): array {

        /** @noinspection SqlNoDataSourceInspection */
        $dql = "SELECT sp.name AS name, sp.type AS type, sp.id AS id
                    FROM \\Entities\\SwitchPort sp
                        LEFT JOIN sp.Switcher s
                        LEFT JOIN sp.PhysicalInterface pi ";


        if( $cid != null ) {
            $dql .= " LEFT JOIN pi.VirtualInterface vi 
                      LEFT JOIN vi.Customer c";
        }

        // Remove the switch ports already in use by all patch panels
        $dql .= " WHERE sp.id NOT IN ( SELECT IDENTITY(ppp.switchPort)
                    FROM Entities\\PatchPanelPort ppp
                    WHERE ppp.switchPort IS NOT NULL";

        if( $spid != null ) {
            $dql .= " AND ppp.switchPort != $spid";
        }

        $dql .= ") AND s.id = ?1";

        if( $cid != null ) {
            $dql .= " AND c.id = $cid";
        }

        $dql .= " ORDER BY sp.id ASC";

        $query = $this->getEntityManager()->createQuery( $dql );
        $query->setParameter( 1, $id);

        $ports = $query->getArrayResult();

        foreach( $ports as $id => $port ){
            $ports[$id]['type'] = \Entities\SwitchPort::$TYPES[ $port['type'] ];
        }

        return $ports;
    }


    /**
     * Returns all available switch ports where available means not in use by a
     * patch panel port and not assigned to a physical interface.
     *
     * Function specifically for use with the patch panel ports functionality.
     *
     * Not suitable for other generic use.
     *
     * @param int      $id     Switch ID - switch to query
     * @param int|null $spid   Switch port ID, if set, this port is excluded from the results
     * @return array
     */
    public function getAllPortsPrewired( int $id, int $spid = null ): array {
        /** @noinspection SqlNoDataSourceInspection */
        $dql = "SELECT sp.name AS name, sp.type AS type, sp.id AS id
                    FROM \\Entities\SwitchPort sp
                        LEFT JOIN sp.Switcher s ";


        // Remove the switch port already use by a patch panel port
        $dql .= " WHERE sp.id NOT IN (SELECT IDENTITY(ppp.switchPort)
                                      FROM Entities\\PatchPanelPort ppp
                                      WHERE ppp.switchPort IS NOT NULL";

        if( $spid !== null ){
            $dql .= " AND ppp.switchPort != $spid";
        }

        $dql .= ") AND s.id = ?1";


        $dql .= " AND sp.id NOT IN (SELECT IDENTITY(pi.SwitchPort)
                                      FROM Entities\\PhysicalInterface pi)";

        $dql .= " AND ((sp.type = 0)  OR (sp.type = 1))";

        $dql .= " ORDER BY sp.id ASC";

        $query = $this->getEntityManager()->createQuery( $dql );
        $query->setParameter( 1, $id);

        $ports = $query->getArrayResult();

        foreach( $ports as $id => $port ){
            $ports[$id]['type'] = \Entities\SwitchPort::$TYPES[ $port['type'] ];
        }

        return $ports;
    }

    /**
     * Returns all available switch ports for a switch which are not assigned to a physical interface.
     *
     *
     * @param int      $id     Switch ID - switch to query
     * @param array    $types  Array of switch port types to limit the results to, if empty - return all types
     * @param int|null $spid   Switch port ID, if set, this port is excluded from the results
     * @return array
     */
    public function getAllPortsNotAssignedToPI( int $id, array $types = [], int $spid = null ): array {

        $dql = "SELECT sp.name AS name, sp.type AS typeid, sp.id AS id
                    FROM Entities\\SwitchPort sp
                        LEFT JOIN sp.Switcher s
                        LEFT JOIN sp.PhysicalInterface pi
                    WHERE
                        s.id = ?1 
                        AND pi.id IS NULL ";

        if( $spid !== null ) {
            $dql .= 'AND sp.id != ?2 ';
        }

        // limit to ports suitable for peering?
        if( $types !== [] ) {
            $dql .= 'AND sp.type IN ( ?3 )';
        }

        $dql .= " ORDER BY sp.id ASC";

        $query = $this->getEntityManager()->createQuery( $dql );
        $query->setParameter( 1, $id );

        if( $spid  !== null ) {
            $query->setParameter( 2, $spid );
        }

        if( $types !== [] ) {
            $query->setParameter( 3, $types );
        }

        $ports = $query->getArrayResult();

        // resolve port types into names:
        foreach( $ports as $id => $port ) {
            $ports[ $id ][ 'type' ] = \Entities\SwitchPort::$TYPES[ $port[ 'typeid' ] ];
        }

        return $ports;
    }

    /**
     * Returns all available switch ports for a switch.
     *
     * Restrict to only some types of switch port
     * Exclude switch port ids from the list
     *
     * Suitable for other generic use.
     *
     * @param int      $id     Switch ID - switch to query
     * @param array    $types  Switch port type restrict to some types only
     * @param array    $spid   Switch port IDs, if set, those ports are excluded from the results
     * @return array
     */
    public function getAllPorts( int $id, $types = [], $spid = [], bool $notAssignToPI = true ): array {

        $dql = "SELECT sp.name AS name, sp.type AS type, sp.id AS id
                    FROM Entities\\SwitchPort sp
                    LEFT JOIN sp.Switcher s";

        if( $notAssignToPI ){
            $dql .= " LEFT JOIN sp.PhysicalInterface pi";
        }

        $dql .= " WHERE s.id = ?1 ";

        if( $notAssignToPI ){
            $dql .= " AND pi.id IS NULL ";
        }

        if( count( $spid ) > 0 ){
            $dql .= ' AND sp.id NOT IN ('.implode( ',', $spid ).') ';
        }

        if( count( $types ) > 0 ){
            $dql .= ' AND sp.type IN ('.implode( ',', $types ).') ';
        }

        $dql .= " ORDER BY sp.id ASC ";

        $query = $this->getEntityManager()->createQuery( $dql );
        $query->setParameter( 1, $id );

        $ports = $query->getArrayResult();

        foreach( $ports as $id => $port )
            $ports[$id]['type'] = \Entities\SwitchPort::$TYPES[ $port['type'] ];

        return $ports;
    }

    /**
     * Returns all the vlan associated to the following switch ID
     *
     * @param int      $id     Switch ID - switch to query
     * @return array
     */
    public function getAllVlan( int $id ): array {

        /** @noinspection SqlNoDataSourceInspection */
        $dql = "SELECT vl.name, vl.private, vl.number
                    FROM Entities\\VlanInterface vli
                    LEFT JOIN vli.Vlan vl
                    LEFT JOIN vli.VirtualInterface vi
                    LEFT JOIN vi.PhysicalInterfaces pi
                    LEFT JOIN pi.SwitchPort sp
                    LEFT JOIN sp.Switcher s
                    WHERE s.id = ?1 
                    GROUP BY vl.id";

        $query = $this->getEntityManager()->createQuery( $dql );
        $query->setParameter( 1, $id);

        $listVlan = $query->getArrayResult();

        $vlans = [];

        foreach( $listVlan as $vlan ){
            $vlans[] = $vlan;
        }

        return $vlans;
    }

    /**
     * Returns all the core link interface associated to the following switch ID
     *
     * @param int      $id     Switch ID - switch to query
     * @return array
     */
    public function getAllCoreLinkInterfaces( int $id ): array {

        /** @noinspection SqlNoDataSourceInspection */
        $dql = "SELECT cb.enabled, cb.description, cl.bfd, spA.name, spB.name, cl.ipv4_subnet, sA.id as saId, sB.id as sbId
                    FROM Entities\\CoreLink cl
                    LEFT JOIN cl.coreBundle cb
                    
                    LEFT JOIN cl.coreInterfaceSideA ciA
                    LEFT JOIN cl.coreInterfaceSideB ciB
                    
                    
                    LEFT JOIN ciA.physicalInterface piA
                    LEFT JOIN ciB.physicalInterface piB
                    
                    LEFT JOIN piA.SwitchPort spA
                    LEFT JOIN piB.SwitchPort spB
                    
                    LEFT JOIN spA.Switcher sA
                    LEFT JOIN spB.Switcher sB
                    
                    WHERE sA.id = ?1 OR sB.id = ?1
                    AND cb.type = ".CoreBundle::TYPE_ECMP;

        $query = $this->getEntityManager()->createQuery( $dql );
        $query->setParameter( 1, $id);

        $listCoreInterface = $query->getArrayResult();

        $cis = [];

        foreach( $listCoreInterface as $ci ){
            $cis[] = $ci;
        }

        return $cis;
    }
}
