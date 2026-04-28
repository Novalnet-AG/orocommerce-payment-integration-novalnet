<?php

namespace Novalnet\Bundle\NovalnetBundle\Settings\DataProvider;

/**
 * Novalnet Payment Settings Dataproider
 */
 
class BasicNovalnetSettingsDataProvider implements NovalnetSettingsDataProviderInterface
{
    /**
     * @internal
     */
    const CAPTURE = 'capture';

    /**
     * @internal
     */
    const AUTHORIZE = 'authorize';

    /**
     * @internal
     */
    const VISA = 'visa';

    /**
     * @internal
     */
    const MASTERCARD = 'mastercard';

    /**
     * @internal
     */
    const MAESTRO = 'maestro';

    /**
     * @internal
     */
    const AMERICAN_EXPRESS = 'amex';

    /**
     * @internal
     */
    const UNIONPAY = 'unionpay';

    /**
     * @internal
     */
    const DISCOVER = 'discover';

    /**
     * @internal
     */
    const DINERS = 'diners';

    /**
     * @internal
     */
    const CARTE_BLEUE = 'carte_bleue';

    /**
     * @internal
     */
    const CARTASI = 'cartasi';

    /**
     * @internal
     */
    const JCB = 'jcb';

    /**
     * @return string[]
     */
    public function getPaymentActions()
    {
        return [
            self::CAPTURE,
            self::AUTHORIZE,
        ];
    }

    /**
     * @return string[]
     */
    public function getCreditCardLogos()
    {
        return [
            self::VISA,
            self::MASTERCARD,
            self::MAESTRO,
            self::AMERICAN_EXPRESS,
            self::UNIONPAY,
            self::DISCOVER,
            self::DINERS,
            self::CARTE_BLEUE,
            self::CARTASI,
            self::JCB,
        ];
    }
}
