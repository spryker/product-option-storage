<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductOptionStorage\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\ProductOptionStorage\Business\Storage\ProductOptionStorageWriter;
use Spryker\Zed\ProductOptionStorage\Business\Storage\ProductOptionStorageWriterInterface;
use Spryker\Zed\ProductOptionStorage\ProductOptionStorageDependencyProvider;

/**
 * @method \Spryker\Zed\ProductOptionStorage\ProductOptionStorageConfig getConfig()
 * @method \Spryker\Zed\ProductOptionStorage\Persistence\ProductOptionStorageQueryContainerInterface getQueryContainer()
 */
class ProductOptionStorageBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\ProductOptionStorage\Business\Storage\ProductOptionStorageWriterInterface
     */
    public function createProductOptionStorageWriter(): ProductOptionStorageWriterInterface
    {
        return new ProductOptionStorageWriter(
            $this->getProductOptionFacade(),
            $this->getStoreFacade(),
            $this->getQueryContainer(),
            $this->getConfig()->isSendingToQueue(),
            $this->getProductOptionCollectionFilterPlugins(),
        );
    }

    /**
     * @return array<\Spryker\Zed\ProductOptionStorageExtension\Dependency\Plugin\ProductOptionCollectionFilterPluginInterface>
     */
    public function getProductOptionCollectionFilterPlugins(): array
    {
        return $this->getProvidedDependency(ProductOptionStorageDependencyProvider::PLUGINS_PRODUCT_OPTION_COLLECTION_FILTER);
    }

    /**
     * @return \Spryker\Zed\ProductOptionStorage\Dependency\Facade\ProductOptionStorageToProductOptionFacadeInterface
     */
    protected function getProductOptionFacade()
    {
        return $this->getProvidedDependency(ProductOptionStorageDependencyProvider::FACADE_PRODUCT_OPTION);
    }

    /**
     * @return \Spryker\Zed\ProductOptionStorage\Dependency\Facade\ProductOptionStorageToStoreFacadeInterface
     */
    protected function getStoreFacade()
    {
        return $this->getProvidedDependency(ProductOptionStorageDependencyProvider::FACADE_STORE);
    }
}
