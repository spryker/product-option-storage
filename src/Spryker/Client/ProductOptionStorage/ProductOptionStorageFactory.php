<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductOptionStorage;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ProductOptionStorage\Dependency\Client\ProductOptionStorageToPermissionClientInterface;
use Spryker\Client\ProductOptionStorage\Price\ValuePriceReader;
use Spryker\Client\ProductOptionStorage\Storage\ProductOptionStorageReader;

class ProductOptionStorageFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Client\ProductOptionStorage\Storage\ProductOptionStorageReaderInterface
     */
    public function createProductOptionStorageReader()
    {
        return new ProductOptionStorageReader(
            $this->getStorage(),
            $this->getStore(),
            $this->getSynchronizationService(),
            $this->createValuePriceReader(),
            $this->getPermissionClient()
        );
    }

    /**
     * @return \Spryker\Client\ProductOptionStorage\Dependency\Client\ProductOptionStorageToStorageInterface
     */
    protected function getStorage()
    {
        return $this->getProvidedDependency(ProductOptionStorageDependencyProvider::CLIENT_STORAGE);
    }

    /**
     * @return \Spryker\Client\ProductOptionStorage\Dependency\Service\ProductOptionStorageToSynchronizationServiceBridge
     */
    protected function getSynchronizationService()
    {
        return $this->getProvidedDependency(ProductOptionStorageDependencyProvider::SERVICE_SYNCHRONIZATION);
    }

    /**
     * @return \Spryker\Client\ProductOptionStorage\Price\ValuePriceReaderInterface
     */
    protected function createValuePriceReader()
    {
        return new ValuePriceReader(
            $this->getCurrencyClient(),
            $this->getPriceClient()
        );
    }

    /**
     * @return \Spryker\Client\ProductOptionStorage\Dependency\Client\ProductOptionStorageToPriceClientInterface
     */
    protected function getPriceClient()
    {
        return $this->getProvidedDependency(ProductOptionStorageDependencyProvider::CLIENT_PRICE);
    }

    /**
     * @return \Spryker\Client\ProductOptionStorage\Dependency\Client\ProductOptionStorageToCurrencyClientInterface
     */
    protected function getCurrencyClient()
    {
        return $this->getProvidedDependency(ProductOptionStorageDependencyProvider::CLIENT_CURRENCY);
    }

    /**
     * @return \Spryker\Client\ProductOptionStorage\Dependency\Client\ProductOptionStorageToPermissionClientInterface
     */
    protected function getPermissionClient(): ProductOptionStorageToPermissionClientInterface
    {
        return $this->getProvidedDependency(ProductOptionStorageDependencyProvider::CLIENT_PERMISSION);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore()
    {
        return $this->getProvidedDependency(ProductOptionStorageDependencyProvider::STORE);
    }
}
