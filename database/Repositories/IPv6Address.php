<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;

/**
 * IPv6Address
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IPv6Address extends EntityRepository
{
    /**
     * Returns IPv6 addresses array for given customer
     *
     * Return array contains only IPv6 addresses like:
     * ["x:x:x:x:x:x:x:x", "x:x:x:x:x:x:x:x", ..., "x:x:x:x:x:x:x:x"]
     *
     * @param \Entities\Customer
     * @return array
     */
    public function getArrayForCustomer( $customer )
    {
        $addresses = $this->getEntityManager()->createQuery(
            "SELECT ip6.address as address
        
             FROM \\Entities\\IPv6Address ip6
                 LEFT JOIN ip6.VlanInterface vi
                 LEFT JOIN vi.VirtualInterface viri
        
             WHERE viri.Customer = ?1"
        )
        ->setParameter( 1, $customer )
        ->getArrayResult();

        if( !$addresses )
            return [];
        else
            return array_map( 'current', $addresses );
    }

    /** 
     * Find VLAN interfaces by (partial) IP address
     * 
     * @param  string $ip The IP address to search for
     * @return \Entities\VlanInterface[] Matching interfaces
     */
    public function findVlanInterfaces( $ip )
    {
        return $this->getEntityManager()->createQuery(
                "SELECT vli
        
                 FROM \\Entities\\VlanInterface vli
                 LEFT JOIN vli.IPv6Address ip

                 WHERE ip.address LIKE :ip"
            )
            ->setParameter( 'ip', strtolower( "%{$ip}" ) )
            ->getResult();
    }


    /**
     * Get all IPv6 address for listing on the frontend
     *
     * @param int $vlanid Get all IP for a vlan ?
     *
     * @return array All Ip address
     */
    public function getAllForList( int $vlanid = null )
    {

        $dql = "SELECT  ip.id as id, 
                        ip.address as address,
                        v.name AS vlan, 
                        v.id as vlanid,
                        vli.id AS vliid,
                        vli.ipv4hostname AS hostname,
                        c.name AS customer, 
                        c.id AS customerid,
                        vi.id AS viid
                        
                FROM Entities\\IPv6Address ip
                LEFT JOIN ip.Vlan as v
                LEFT JOIN ip.VlanInterface as vli
                LEFT JOIN vli.VirtualInterface as vi
                LEFT JOIN vi.Customer as c ";



        if( $vlanid ) {
            $dql .= " WHERE v.id = " . (int)$vlanid;
        }

        $dql .= " ORDER BY address ASC" ;


        $query = $this->getEntityManager()->createQuery( $dql );

        return $query->getArrayResult();
    }
}
