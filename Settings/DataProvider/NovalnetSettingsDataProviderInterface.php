<?php

namespace Novalnet\Bundle\NovalnetBundle\Settings\DataProvider;

/**
 * Novalnet Settings Data Provider Interface
 */

interface NovalnetSettingsDataProviderInterface
{
    /**
     * @return string[]
     */
    public function getPaymentActions();

    /**
     * @return string[]
     */
    public function getCreditCardLogos();
}
