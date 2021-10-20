<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductOptionStorage;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductOptionStorage\Dependency\Facade\ProductOptionStorageToEventBehaviorFacadeBridge;
use Spryker\Zed\ProductOptionStorage\Dependency\Facade\ProductOptionStorageToProductOptionFacadeBridge;
use Spryker\Zed\ProductOptionStorage\Dependency\Facade\ProductOptionStorageToStoreFacadeBridge;
use Spryker\Zed\ProductOptionStorage\Dependency\QueryContainer\ProductOptionStorageToProductOptionQueryContainerBridge;
use Spryker\Zed\ProductOptionStorage\Dependency\QueryContainer\ProductOptionStorageToProductQueryContainerBridge;

/**
 * @method \Spryker\Zed\ProductOptionStorage\ProductOptionStorageConfig getConfig()
 */
class ProductOptionStorageDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const QUERY_CONTAINER_PRODUCT = 'QUERY_CONTAINER_PRODUCT';

    /**
     * @var string
     */
    public const QUERY_CONTAINER_PRODUCT_OPTION = 'QUERY_CONTAINER_PRODUCT_OPTION';

    /**
     * @var string
     */
    public const FACADE_PRODUCT_OPTION = 'FACADE_PRODUCT_OPTION';

    /**
     * @var string
     */
    public const FACADE_EVENT_BEHAVIOR = 'FACADE_EVENT_BEHAVIOR';

    /**
     * @var string
     */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @var string
     */
    public const PLUGINS_PRODUCT_OPTION_COLLECTION_FILTER = 'PLUGINS_PRODUCT_OPTION_COLLECTION_FILTER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = $this->addEventBehaviorFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = $this->addProductOptionFacade($container);
        $container = $this->addStoreFacade($container);
        $container = $this->addProductOptionCollectionFilterPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container)
    {
        $container = $this->addProductOptionQueryContainer($container);
        $container = $this->addProductQueryContainer($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventBehaviorFacade(Container $container)
    {
        $container->set(static::FACADE_EVENT_BEHAVIOR, function (Container $container) {
            return new ProductOptionStorageToEventBehaviorFacadeBridge($container->getLocator()->eventBehavior()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container)
    {
        $container->set(static::FACADE_STORE, function (Container $container) {
            return new ProductOptionStorageToStoreFacadeBridge($container->getLocator()->store()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductOptionFacade(Container $container): Container
    {
        $container->set(static::FACADE_PRODUCT_OPTION, function (Container $container) {
            return new ProductOptionStorageToProductOptionFacadeBridge($container->getLocator()->productOption()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductOptionQueryContainer(Container $container): Container
    {
        $container->set(static::QUERY_CONTAINER_PRODUCT_OPTION, function (Container $container) {
            return new ProductOptionStorageToProductOptionQueryContainerBridge($container->getLocator()->productOption()->queryContainer());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductQueryContainer(Container $container): Container
    {
        $container->set(static::QUERY_CONTAINER_PRODUCT, function (Container $container) {
            return new ProductOptionStorageToProductQueryContainerBridge($container->getLocator()->product()->queryContainer());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductOptionCollectionFilterPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_PRODUCT_OPTION_COLLECTION_FILTER, function (Container $container) {
            return $this->getProductOptionCollectionFilterPlugins();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\ProductOptionStorageExtension\Dependency\Plugin\ProductOptionCollectionFilterPluginInterface>
     */
    protected function getProductOptionCollectionFilterPlugins(): array
    {
        return [];
    }
}
