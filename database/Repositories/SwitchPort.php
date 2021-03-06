<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;

/**
 * SwitchPort
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SwitchPort extends EntityRepository
{
    /**
     * Return an array of all switch port names where the array key is the switch port id.
     * @author Yann Robin
     * @return array An array of all switch port names with the switch port id as the key.
     */
    public function getForArray(): array {
        foreach(self::findAll() as $switchPort){
            $listSwitchPort[$switchPort->getId()] = $switchPort->getName();
        }
        return $listSwitchPort;
    }

    public function getCustomerForASwitchPort($switchPortId)
    {
        $dql = "SELECT cu.id
                    FROM \\Entities\\SwitchPort sp
                        LEFT JOIN sp.Switcher s
                        LEFT JOIN sp.PhysicalInterface pi
                        LEFT JOIN pi.VirtualInterface vi 
                        LEFT JOIN vi.Customer cu
                        WHERE sp.id = $switchPortId ";


      return $this->getEntityManager()->createQuery( $dql )->getOneOrNullResult()['id'];
    }
}
