<?php

namespace Novalnet\Bundle\NovalnetBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Novalnet\Bundle\NovalnetBundle\Migrations\Schema\v2_0;

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
        return 'v2_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $createNovalnetPaymentTables = new v2_0\CreateNovalnetPaymentTables();
        $createNovalnetPaymentTables->up($schema, $queries);
    }
}
