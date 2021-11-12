<?php

namespace Oro\Bundle\NovalnetPaymentBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Repository for NovalnetPaymentSettings entity
 */
class NovalnetPaymentSettingsRepository extends EntityRepository
{
    /**
     * @return NovalnetPaymentSettings[]
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
