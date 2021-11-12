<?php

namespace Oro\Bundle\NovalnetPaymentBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use Oro\Bundle\ConfigBundle\Migration\RenameConfigSectionQuery;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class OroNovalnetPaymentBundleInstaller implements Installation, ContainerAwareInterface
{
	/**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
		// update system configuration for installed instances
        if ($this->container->hasParameter('installed') && $this->container->getParameter('installed')) {
            $queries->addPostQuery(new RenameConfigSectionQuery('orob2b_novalnet_payment', 'oro_novalnet_payment'));
        }
        
        /** Tables generation **/
        $this->updateOroIntegrationTransportTable($schema);
        $this->createOroNovalnetPaymentCallbackHistoryTable($schema);
        $this->createOroNovalnetPaymentShortLabelTable($schema);
        $this->createOroNovalnetPaymentTransLabelTable($schema);
        $this->createOroNovalnetPaymentTransactionDetailsTable($schema);

        /** Foreign keys generation **/
        $this->addOroNovalnetPaymentShortLabelForeignKeys($schema);
        $this->addOroNovalnetPaymentTransLabelForeignKeys($schema);
    }

    /**
     * @param Schema $schema
     *
     * @throws SchemaException
     */
    private function updateOroIntegrationTransportTable(Schema $schema)
    {
        $table = $schema->getTable('oro_integration_transport');

        $table->addColumn('novalnet_payment_vendor_id', 'text', ['notnull' => false]);
        $table->addColumn('novalnet_payment_authcode', 'text', ['notnull' => false]);
        $table->addColumn('novalnet_payment_product', 'text', ['notnull' => false]);
        $table->addColumn('novalnet_payment_tariff', 'text', ['notnull' => false]);
        $table->addColumn('novalnet_payment_payment_access_key', 'text', ['notnull' => false]);
        $table->addColumn('novalnet_payment_referrer_id', 'text', ['notnull' => false]);
    }

    /**
     * Create oro_novalnet_payment_callback_history table
     *
     * @param Schema $schema
     */
    protected function createOroNovalnetPaymentCallbackHistoryTable(Schema $schema)
    {
        $table = $schema->createTable('oro_novalnet_payment_callback_history');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('date', 'datetime', []);
        $table->addColumn('callback_amount', 'integer', []);
        $table->addColumn('order_no', 'string', ['length' => 255]);
        $table->addColumn('org_tid', 'bigint', []);
        $table->addColumn('callback_tid', 'bigint', []);
        $table->setPrimaryKey(['id']);
    }

    /**
     * Create oro_novalnet_payment_short_label table
     *
     * @param Schema $schema
     */
    protected function createOroNovalnetPaymentShortLabelTable(Schema $schema)
    {
        $table = $schema->createTable('oro_novalnet_payment_short_label');
        $table->addColumn('transport_id', 'integer', []);
        $table->addColumn('localized_value_id', 'integer', []);
        $table->setPrimaryKey(['transport_id', 'localized_value_id']);
        $table->addUniqueIndex(['localized_value_id'], 'UNIQ_B284781DEB576E89');
        $table->addIndex(['transport_id'], 'IDX_B284781D9909C13F', []);
    }

    /**
     * Create oro_novalnet_payment_trans_label table
     *
     * @param Schema $schema
     */
    protected function createOroNovalnetPaymentTransLabelTable(Schema $schema)
    {
        $table = $schema->createTable('oro_novalnet_payment_trans_label');
        $table->addColumn('transport_id', 'integer', []);
        $table->addColumn('localized_value_id', 'integer', []);
        $table->setPrimaryKey(['transport_id', 'localized_value_id']);
        $table->addUniqueIndex(['localized_value_id'], 'UNIQ_8D42BDC7EB576E89');
        $table->addIndex(['transport_id'], 'IDX_8D42BDC79909C13F', []);
    }

    /**
     * Create oro_novalnet_payment_transaction_details table
     *
     * @param Schema $schema
     */
    protected function createOroNovalnetPaymentTransactionDetailsTable(Schema $schema)
    {
        $table = $schema->createTable('oro_novalnet_payment_transaction_details');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('tid', 'bigint', []);
        $table->addColumn('gateway_status', 'integer', []);
        $table->addColumn('test_mode', 'integer', []);
        $table->addColumn('amount', 'integer', []);
        $table->addColumn('currency', 'string', ['length' => 255]);
        $table->addColumn('payment_type', 'text', []);
        $table->addColumn('customer_no', 'string', ['length' => 255]);
        $table->addColumn('order_no', 'string', ['length' => 255]);
        $table->setPrimaryKey(['id']);
    }

    /**
     * Add oro_novalnet_payment_short_label foreign keys.
     *
     * @param Schema $schema
     */
    protected function addOroNovalnetPaymentShortLabelForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('oro_novalnet_payment_short_label');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_integration_transport'),
            ['transport_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_fallback_localization_val'),
            ['localized_value_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }

    /**
     * Add oro_novalnet_payment_trans_label foreign keys.
     *
     * @param Schema $schema
     */
    protected function addOroNovalnetPaymentTransLabelForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('oro_novalnet_payment_trans_label');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_integration_transport'),
            ['transport_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_fallback_localization_val'),
            ['localized_value_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }
}
