<?php

namespace Novalnet\Bundle\NovalnetBundle;

use Novalnet\Bundle\NovalnetBundle\DependencyInjection\NovalnetExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Novalnet bundle class
 */
class NovalnetBundle extends Bundle
{
    /**
     * @return NovalnetExtension
     */
    public function getContainerExtension()
    {
        if (!$this->extension) {
            $this->extension = new NovalnetExtension();
        }

        return $this->extension;
    }
}
