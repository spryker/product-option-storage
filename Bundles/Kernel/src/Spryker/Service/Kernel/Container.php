<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Service\Kernel;

use Pimple;
use Spryker\Shared\Kernel\ContainerInterface;

class Container extends Pimple implements ContainerInterface
{
    /**
     * @return \Generated\Service\Ide\AutoCompletion|\Spryker\Shared\Kernel\LocatorLocatorInterface
     */
    public function getLocator()
    {
        return Locator::getInstance();
    }
}
