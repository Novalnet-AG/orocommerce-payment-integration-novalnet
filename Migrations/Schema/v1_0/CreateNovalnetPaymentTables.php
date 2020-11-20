<?php

namespace Novalnet\Bundle\NovalnetBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * Installer for Novalnet Payment bundle.
 */
class CreateNovalnetPaymentTables implements Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Add column in  OroIntegrationTransportTable table **/
        $this->updateOroIntegrationTransportTable($schema);

        /** Tables generation **/
        $this->createNnBanktransferLblTable($schema);
        $this->createNnBanktransferShLblTable($schema);
        $this->createNnCashpaymentLblTable($schema);
        $this->createNnCashpaymentShLblTable($schema);
        $this->createNnCreditCardLblTable($schema);
        $this->createNnCreditCardShLblTable($schema);
        $this->createNnEpsLblTable($schema);
        $this->createNnEpsShLblTable($schema);
        $this->createNnGiropayLblTable($schema);
        $this->createNnGiropayShLblTable($schema);
        $this->createNnIdealLblTable($schema);
        $this->createNnIdealShLblTable($schema);
        $this->createNnInvoiceLblTable($schema);
        $this->createNnInvoiceShLblTable($schema);
        $this->createNnPaypalLblTable($schema);
        $this->createNnPaypalShLblTable($schema);
        $this->createNnPrepaymentLblTable($schema);
        $this->createNnPrepaymentShLblTable($schema);
        $this->createNnPrzelewyLblTable($schema);
        $this->createNnPrzelewyShLblTable($schema);
        $this->createNnSepaLblTable($schema);
        $this->createNnSepaShLblTable($schema);
        $this->createNnTransactionDetailsTable($schema);
        $this->createNnCallbackHistoryTable($schema);
    }

    /**
     * Update oro_integration_transport table
     * @param Schema $schema
     */
    protected function updateOroIntegrationTransportTable(Schema $schema)
    {
        $table = $schema->getTable('oro_integration_transport');
        $fieldConfiguration = self::getFieldConfiguration();
        foreach ($fieldConfiguration as $key => $value) {
            if (!$table->hasColumn($key)) {
                $table->addColumn($key, $value['type'], $value['options']);
            }
        }
    }

    /**
     * Create nn_banktransfer_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnBanktransferLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_banktransfer_lbl')) {
            $table = $schema->createTable('nn_banktransfer_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_47AA7636EB576E89');
            $table->addIndex(['transport_id'], 'IDX_47AA76369909C13F', []);
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

    /**
     * Create nn_banktransfer_sh_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnBanktransferShLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_banktransfer_sh_lbl')) {
            $table = $schema->createTable('nn_banktransfer_sh_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_986D3D43EB576E89');
            $table->addIndex(['transport_id'], 'IDX_986D3D439909C13F', []);
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

    /**
     * Create nn_callback_history table
     *
     * @param Schema $schema
     */
    protected function createNnCallbackHistoryTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_callback_history')) {
            $table = $schema->createTable('nn_callback_history');
            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('date', 'datetime', ['notnull' => false, 'comment' => '(DC2Type:datetime)']);
            $table->addColumn('callback_amount', 'integer', ['notnull' => false, 'length' => 11]);
            $table->addColumn('order_no', 'string', ['notnull' => false, 'length' => 30]);
            $table->addColumn('org_tid', 'bigint', ['notnull' => false, 'length' => 20]);
            $table->addColumn('callback_tid', 'bigint', ['notnull' => false, 'length' => 20]);
            $table->setPrimaryKey(['id']);
        }
    }

    /**
     * Create nn_cashpayment_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnCashpaymentLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_cashpayment_lbl')) {
            $table = $schema->createTable('nn_cashpayment_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_77D9E1F3EB576E89');
            $table->addIndex(['transport_id'], 'IDX_77D9E1F39909C13F', []);
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

    /**
     * Create nn_cashpayment_sh_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnCashpaymentShLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_cashpayment_sh_lbl')) {
            $table = $schema->createTable('nn_cashpayment_sh_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_F8055583EB576E89');
            $table->addIndex(['transport_id'], 'IDX_F80555839909C13F', []);
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

    /**
     * Create nn_credit_card_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnCreditCardLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_credit_card_lbl')) {
            $table = $schema->createTable('nn_credit_card_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_6C04E44AEB576E89');
            $table->addIndex(['transport_id'], 'IDX_6C04E44A9909C13F', []);
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

    /**
     * Create nn_credit_card_sh_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnCreditCardShLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_credit_card_sh_lbl')) {
            $table = $schema->createTable('nn_credit_card_sh_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_B79FCA2BEB576E89');
            $table->addIndex(['transport_id'], 'IDX_B79FCA2B9909C13F', []);
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

    /**
     * Create nn_eps_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnEpsLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_eps_lbl')) {
            $table = $schema->createTable('nn_eps_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_99B11A93EB576E89');
            $table->addIndex(['transport_id'], 'IDX_99B11A939909C13F', []);
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

    /**
     * Create nn_eps_sh_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnEpsShLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_eps_sh_lbl')) {
            $table = $schema->createTable('nn_eps_sh_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_4F34F51EB576E89');
            $table->addIndex(['transport_id'], 'IDX_4F34F519909C13F', []);
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

    /**
     * Create nn_giropay_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnGiropayLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_giropay_lbl')) {
            $table = $schema->createTable('nn_giropay_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_B5EAC234EB576E89');
            $table->addIndex(['transport_id'], 'IDX_B5EAC2349909C13F', []);
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

    /**
     * Create nn_giropay_sh_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnGiropayShLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_giropay_sh_lbl')) {
            $table = $schema->createTable('nn_giropay_sh_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_6D9CC3F3EB576E89');
            $table->addIndex(['transport_id'], 'IDX_6D9CC3F39909C13F', []);
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

    /**
     * Create nn_ideal_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnIdealLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_ideal_lbl')) {
            $table = $schema->createTable('nn_ideal_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_D3E2AC2BEB576E89');
            $table->addIndex(['transport_id'], 'IDX_D3E2AC2B9909C13F', []);
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

    /**
     * Create nn_ideal_sh_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnIdealShLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_ideal_sh_lbl')) {
            $table = $schema->createTable('nn_ideal_sh_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_8F43E9C3EB576E89');
            $table->addIndex(['transport_id'], 'IDX_8F43E9C39909C13F', []);
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

    /**
     * Create nn_invoice_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnInvoiceLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_invoice_lbl')) {
            $table = $schema->createTable('nn_invoice_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_4232A1D2EB576E89');
            $table->addIndex(['transport_id'], 'IDX_4232A1D29909C13F', []);
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

    /**
     * Create nn_invoice_sh_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnInvoiceShLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_invoice_sh_lbl')) {
            $table = $schema->createTable('nn_invoice_sh_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_62B0D94EB576E89');
            $table->addIndex(['transport_id'], 'IDX_62B0D949909C13F', []);
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

    /**
     * Create nn_paypal_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnPaypalLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_paypal_lbl')) {
            $table = $schema->createTable('nn_paypal_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_6D640322EB576E89');
            $table->addIndex(['transport_id'], 'IDX_6D6403229909C13F', []);
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

    /**
     * Create nn_paypal_sh_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnPaypalShLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_paypal_sh_lbl')) {
            $table = $schema->createTable('nn_paypal_sh_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_ADD654C1EB576E89');
            $table->addIndex(['transport_id'], 'IDX_ADD654C19909C13F', []);
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

    /**
     * Create nn_prepayment_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnPrepaymentLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_prepayment_lbl')) {
            $table = $schema->createTable('nn_prepayment_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_496DDCECEB576E89');
            $table->addIndex(['transport_id'], 'IDX_496DDCEC9909C13F', []);
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

    /**
     * Create nn_prepayment_sh_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnPrepaymentShLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_prepayment_sh_lbl')) {
            $table = $schema->createTable('nn_prepayment_sh_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_499B8EDBEB576E89');
            $table->addIndex(['transport_id'], 'IDX_499B8EDB9909C13F', []);
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

    /**
     * Create nn_przelewy_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnPrzelewyLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_przelewy_lbl')) {
            $table = $schema->createTable('nn_przelewy_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_19FABD77EB576E89');
            $table->addIndex(['transport_id'], 'IDX_19FABD779909C13F', []);
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

    /**
     * Create nn_przelewy_sh_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnPrzelewyShLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_przelewy_sh_lbl')) {
            $table = $schema->createTable('nn_przelewy_sh_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_AA50859BEB576E89');
            $table->addIndex(['transport_id'], 'IDX_AA50859B9909C13F', []);
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

    /**
     * Create nn_sepa_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnSepaLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_sepa_lbl')) {
            $table = $schema->createTable('nn_sepa_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_9EAD195DEB576E89');
            $table->addIndex(['transport_id'], 'IDX_9EAD195D9909C13F', []);
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

    /**
     * Create nn_sepa_sh_lbl table
     *
     * @param Schema $schema
     */
    protected function createNnSepaShLblTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_sepa_sh_lbl')) {
            $table = $schema->createTable('nn_sepa_sh_lbl');
            $table->addColumn('transport_id', 'integer', []);
            $table->addColumn('localized_value_id', 'integer', []);
            $table->setPrimaryKey(['transport_id', 'localized_value_id']);
            $table->addUniqueIndex(['localized_value_id'], 'UNIQ_A0EEFB90EB576E89');
            $table->addIndex(['transport_id'], 'IDX_A0EEFB909909C13F', []);
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

    /**
     * Create nn_transaction_details table
     *
     * @param Schema $schema
     */
    protected function createNnTransactionDetailsTable(Schema $schema)
    {
        if (!$schema->hasTable('nn_transaction_details')) {
            $table = $schema->createTable('nn_transaction_details');
            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('tid', 'bigint', ['notnull' => false, 'length' => 20]);
            $table->addColumn('gateway_status', 'integer', ['notnull' => false, 'length' => 10]);
            $table->addColumn('test_mode', 'boolean', ['default' => '0']);
            $table->addColumn('amount', 'integer', ['notnull' => false, 'length' => 11]);
            $table->addColumn('currency', 'string', ['notnull' => false, 'length' => 5]);
            $table->addColumn('payment_type', 'string', ['notnull' => false, 'length' => 80]);
            $table->addColumn('customer_no', 'string', ['notnull' => false, 'length' => 20]);
            $table->addColumn('order_no', 'string', ['notnull' => false, 'length' => 30]);
            $table->setPrimaryKey(['id']);
        }
    }

    protected function getFieldConfiguration()
    {
        $fieldConfiguration = [
            'nn_vendor_id' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 5]
            ],
            'nn_authcode' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 32]
            ],
            'nn_product' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 5]
            ],
            'nn_tariff' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 5]
            ],
            'nn_access_key' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_referrer_id' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 10]
            ],
            'nn_gateway_timeout' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 5]
            ],
            'nn_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_invoice_duedate' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 2]
            ],
            'nn_sepa_duedate' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 2]
            ],
            'nn_barzahlen_duedate' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 2]
            ],
            'nn_cc_3d' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_onhold_amount' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 11]
            ],
            'nn_callback_testmode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_email_notification' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_email_to' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_email_bcc' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_invoice_guarantee' => [
                'type' => 'boolean',
                'options' => ['notnull' => false, 'default' => '0']
            ],
            'nn_inv_guarantee_min_amount' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 11]
            ],
            'nn_inv_force_non_guarantee' => [
                'type' => 'boolean',
                'options' => ['notnull' => false, 'default' => '0']
            ],
            'nn_sepa_guarantee' => [
                'type' => 'boolean',
                'options' => ['notnull' => false, 'default' => '0']
            ],
            'nn_sepa_guarantee_min_amount' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 11]
            ],
            'nn_sepa_force_non_guarantee' => [
                'type' => 'boolean',
                'options' => ['notnull' => false, 'default' => '0']
            ],
        ];
        return $fieldConfiguration;
    }
}
