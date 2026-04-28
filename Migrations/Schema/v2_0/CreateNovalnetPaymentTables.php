<?php
namespace Novalnet\Bundle\NovalnetBundle\Migrations\Schema\v2_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Oro\Bundle\MigrationBundle\Migration\Migration;

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
        /** Tables generation **/
        $this->createNnCallbackHistoryTable($schema);
        $this->createNnTransactionDetailsTable($schema);
        
        /** Add column in  OroIntegrationTransportTable table **/
        $this->updateOroIntegrationTransportTable($schema);
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
    
    protected function getFieldConfiguration()
    {
         $fieldConfiguration = [
            'nn_tariff' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 5]
            ],
            'nn_invoice_duedate' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 2]
            ],
            'nn_sepa_duedate' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 2]
            ],
            'nn_invoice_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_invoice_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_invoice_action' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 15]
            ],
            'nn_prepayment_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_prepayment_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_sepa_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_sepa_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_sepa_action' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 15]
            ],
            'nn_paypal_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_paypal_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_paypal_action' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 15]
            ],
            'nn_banktransfer_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_banktransfer_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_ideal_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_ideal_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_eps_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_eps_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_giropay_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_giropay_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_przelewy_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_przelewy_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_postfinance_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_postfinance_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_postfinancecard_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_postfinancecard_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_multibanco_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_multibanco_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_bancontact_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_bancontact_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_alipay_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_alipay_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_wechatpay_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_wechatpay_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_trustly_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_trustly_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_ob_transfer_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_ob_transfer_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_cashpayment_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_cashpayment_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_cashpayment_duedate' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 2]
            ],
            'nn_invoice_onhold_amnt' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 20]
            ],
            'nn_instl_inv_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_instl_inv_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_instl_inv_onhold_amnt' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 20]
            ],
            'nn_instl_inv_min_amnt' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 20]
            ],
            'nn_instl_inv_action' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 15]
            ],
            'nn_instl_inv_cycle' => [
                'type' => 'text',
                'options' => ['notnull' => false]
            ],
            'nn_sepa_onhold_amnt' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 20]
            ],
            'nn_paypal_onhold_amnt' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 20]
            ],
            'nn_instl_sepa_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_instl_sepa_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_instl_sepa_onhold_amnt' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 20]
            ],
            'nn_instl_sepa_min_amnt' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 20]
            ],
            'nn_instl_sepa_action' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 15]
            ],
            'nn_instl_sepa_duedate' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 2]
            ],
            'nn_instl_sepa_cycle' => [
                'type' => 'text',
                'options' => ['notnull' => false]
            ],
            'nn_g_sepa_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_g_sepa_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_g_invoice_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_g_invoice_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_g_sepa_action' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 15]
            ],
            'nn_g_sepa_onhold_amnt' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 20]
            ],
            'nn_g_sepa_min_amnt' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 20]
            ],
            'nn_g_sepa_duedate' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 2]
            ],
            'nn_g_invoice_action' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 15]
            ],
            'nn_g_invoice_onhold_amnt' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 20]
            ],
            'nn_g_invoice_min_amnt' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 20]
            ],
            'nn_sepa_oneclick' => [
                'type' => 'boolean',
                'options' => ['notnull' => false]
            ],
            'nn_instl_sepa_oneclick' => [
                'type' => 'boolean',
                'options' => ['notnull' => false]
            ],
            'nn_paypal_oneclick' => [
                'type' => 'boolean',
                'options' => ['notnull' => false]
            ],
            'nn_g_sepa_oneclick' => [
                'type' => 'boolean',
                'options' => ['notnull' => false]
            ],
            'nn_public_key' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_private_key' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_client_key' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_cc_enforce_3d' => [
                'type' => 'boolean',
                'options' => ['notnull' => false]
            ],
            'nn_cc_oneclick' => [
                'type' => 'boolean',
                'options' => ['notnull' => false]
            ],
            'nn_cc_inline_form' => [
                'type' => 'boolean',
                'options' => ['notnull' => false]
            ],
            'nn_cc_payment_action' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 15]
            ],
            'nn_cc_onhold_amount' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 20]
            ],
            'nn_cc_logo' => [
                'type' => 'array',
                'options' => ['notnull' => false, 'length' => 255, 'comment' => '(DC2Type:array)']
            ],
            'nn_display_payment_logo' => [
                'type' => 'boolean',
                'options' => ['notnull' => false]
            ],
            'nn_cc_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_cc_notify' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_cc_input_style' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_cc_label_style' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_cc_container_style' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_prepayment_duedate' => [
                'type' => 'integer',
                'options' => ['notnull' => false, 'length' => 2]
            ],
            'nn_callback_test_mode' => [
                'type' => 'boolean',
                'options' => ['default' => '0', 'notnull' => false]
            ],
            'nn_callback_email_to' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 255]
            ],
            'nn_credit_card_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_credit_card_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_sepa_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_sepa_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_invoice_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_invoice_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_instl_invoice_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_instl_invoice_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_instl_sepa_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_instl_sepa_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_prepayment_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_prepayment_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_cashpayment_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_cashpayment_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_paypal_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_paypal_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_banktransfer_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_banktransfer_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_ideal_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_ideal_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_g_sepa_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_g_sepa_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_g_invoice_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_g_invoice_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_eps_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_eps_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_giropay_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_giropay_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_przelewy_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_przelewy_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_postfinance_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_postfinance_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_postfinance_card_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_postfinance_card_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_bancontact_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_bancontact_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_multibanco_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_multibanco_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_alipay_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_alipay_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_wechatpay_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_wechatpay_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_trustly_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_trustly_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_onlinebanktransfer_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ],
            'nn_onlinebanktransfer_sh_lbl' => [
                'type' => 'string',
                'options' => ['notnull' => false, 'length' => 50]
            ]
         ];
         return $fieldConfiguration;
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
            $table->addColumn('date', 'datetime', ['notnull' => false, 'length' => 0, 'comment' => '(DC2Type:datetime)']);
            $table->addColumn('callback_amount', 'integer', ['notnull' => false, 'length' => 20]);
            $table->addColumn('order_no', 'string', ['notnull' => false, 'length' => 30]);
            $table->addColumn('org_tid', 'bigint', ['notnull' => false, 'length' => 20]);
            $table->addColumn('callback_tid', 'bigint', ['notnull' => false, 'length' => 20]);
            $table->addColumn('payment_type', 'string', ['notnull' => false, 'length' => 64]);
            $table->addColumn('event_type', 'string', ['notnull' => false, 'length' => 64]);
            $table->setPrimaryKey(['id']);
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
            $table->addColumn('status', 'string', ['notnull' => false, 'length' => 30]);
            $table->addColumn('test_mode', 'boolean', ['default' => '0']);
            $table->addColumn('amount', 'integer', ['notnull' => false, 'length' => 30]);
            $table->addColumn('currency', 'string', ['notnull' => false, 'length' => 5]);
            $table->addColumn('payment_type', 'string', ['notnull' => false, 'length' => 80]);
            $table->addColumn('customer_no', 'string', ['notnull' => false, 'length' => 20]);
            $table->addColumn('order_no', 'string', ['notnull' => false, 'length' => 30]);
            $table->addColumn('token', 'string', ['notnull' => false, 'length' => 255]);
            $table->addColumn('payment_data', 'text', ['notnull' => false, 'length' => 0]);
            $table->addColumn('oneclick', 'boolean', ['default' => '0']);
            $table->addColumn('additional_info', 'text', ['notnull' => false]);
            $table->addColumn('refunded_amount', 'integer', ['default' => '0', 'length' => 30]);
            $table->setPrimaryKey(['id']);
        }
    }

}
