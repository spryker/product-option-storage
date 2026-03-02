<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductOptionStorage\Price;

use Generated\Shared\Transfer\ProductAbstractOptionStorageTransfer;
use Generated\Shared\Transfer\ProductOptionValueStorageTransfer;
use Spryker\Client\ProductOptionStorage\Dependency\Client\ProductOptionStorageToCurrencyClientInterface;
use Spryker\Client\ProductOptionStorage\Dependency\Client\ProductOptionStorageToPriceClientInterface;
use Spryker\Shared\ProductOption\ProductOptionConstants;

class ValuePriceReader implements ValuePriceReaderInterface
{
    /**
     * @var \Spryker\Client\ProductOptionStorage\Dependency\Client\ProductOptionStorageToCurrencyClientInterface
     */
    protected $currencyClient;

    /**
     * @var \Spryker\Client\ProductOptionStorage\Dependency\Client\ProductOptionStorageToPriceClientInterface
     */
    protected $priceClient;

    /**
     * @var string|null
     */
    protected static $currentCurrencyCodeBuffer;

    /**
     * @var string|null
     */
    protected static $currentPriceModeBuffer;

    public function __construct(
        ProductOptionStorageToCurrencyClientInterface $currencyClient,
        ProductOptionStorageToPriceClientInterface $priceClient
    ) {
        $this->currencyClient = $currencyClient;
        $this->priceClient = $priceClient;
    }

    public function resolveProductAbstractOptionStorageTransferProductOptionValuePrices(
        ProductAbstractOptionStorageTransfer $productAbstractOptionStorageTransfer
    ): ProductAbstractOptionStorageTransfer {
        $currentCurrencyCode = $this->getCurrentCurrencyCode();
        $currentPriceMode = $this->getCurrentPriceMode();
        $productOptionValueStorageTransfers = [];
        foreach ($productAbstractOptionStorageTransfer->getProductOptionGroups() as $productOptionGroupStorageTransfer) {
            $productOptionValueStorageTransfers[] = $productOptionGroupStorageTransfer->getProductOptionValues()
                ->getArrayCopy();
        }
        $productOptionValueStorageTransfers = array_merge(...$productOptionValueStorageTransfers);

        foreach ($productOptionValueStorageTransfers as $productOptionValueStorageTransfer) {
            $this->resolveProductOptionValuePrice(
                $productOptionValueStorageTransfer,
                $currentCurrencyCode,
                $currentPriceMode,
            );
        }

        return $productAbstractOptionStorageTransfer;
    }

    /**
     * @param array<\Generated\Shared\Transfer\ProductAbstractOptionStorageTransfer> $productAbstractOptionStorageTransfers
     *
     * @return array<\Generated\Shared\Transfer\ProductAbstractOptionStorageTransfer>
     */
    public function resolveProductAbstractOptionStorageTransfersProductOptionValuePrices(
        array $productAbstractOptionStorageTransfers
    ): array {
        foreach ($productAbstractOptionStorageTransfers as $productAbstractOptionStorageTransfer) {
            $this->resolveProductAbstractOptionStorageTransferProductOptionValuePrices(
                $productAbstractOptionStorageTransfer,
            );
        }

        return $productAbstractOptionStorageTransfers;
    }

    protected function resolveProductOptionValuePrice(
        ProductOptionValueStorageTransfer $productOptionValueStorageTransfer,
        string $currencyCode,
        string $priceMode
    ): void {
        $prices = $productOptionValueStorageTransfer->getPrices();
        $price = $prices[$currencyCode][$priceMode][ProductOptionConstants::AMOUNT] ?? null;
        $productOptionValueStorageTransfer->setPrice($price);
    }

    protected function getCurrentCurrencyCode(): string
    {
        if (static::$currentCurrencyCodeBuffer === null) {
            static::$currentCurrencyCodeBuffer = $this->currencyClient->getCurrent()->getCode();
        }

        return static::$currentCurrencyCodeBuffer;
    }

    protected function getCurrentPriceMode(): string
    {
        if (static::$currentPriceModeBuffer === null) {
            static::$currentPriceModeBuffer = $this->priceClient->getCurrentPriceMode();
        }

        return static::$currentPriceModeBuffer;
    }
}
