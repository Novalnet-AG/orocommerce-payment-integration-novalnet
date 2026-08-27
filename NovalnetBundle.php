<?php

namespace Novalnet\Bundle\NovalnetBundle;

use Novalnet\Bundle\NovalnetBundle\DependencyInjection\NovalnetExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;


class NovalnetBundle extends Bundle
{
    #[\Override]
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (!$this->extension) {
            $this->extension = new NovalnetExtension();
        }

        return $this->extension;
    }
}
