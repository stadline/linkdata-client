<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Bridge\Symfony\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

abstract class LinkdataClientBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }
}
