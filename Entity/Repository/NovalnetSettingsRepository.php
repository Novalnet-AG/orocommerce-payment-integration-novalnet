<?php

namespace Novalnet\Bundle\NovalnetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;

/**
 * Repository for NovalnetSettings entity
 */
class NovalnetSettingsRepository extends EntityRepository
{
    /**
     *
     * @return NovalnetSettings[]
     */
    public function getEnabledSettings()
    {
        return $this->createQueryBuilder('settings')
            ->innerJoin('settings.channel', 'channel')
            ->andWhere('channel.enabled = true')
            ->getQuery()
            ->getResult();
    }
}
