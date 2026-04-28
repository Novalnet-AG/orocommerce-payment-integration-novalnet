<?php

namespace Novalnet\Bundle\NovalnetBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Novalnet\Bundle\NovalnetBundle\Migrations\Schema\v2_02;

/**
 * Installer for Novalnet bundle.
 */
class NovalnetBundleInstaller implements Installation
{
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v2_02';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $createNovalnetPaymentTables = new v2_02\CreateNovalnetPaymentTables();
        $createNovalnetPaymentTables->up($schema, $queries);
    }
}
