<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductOptionStorage;

interface ProductOptionStorageClientInterface
{
    /**
     * Specification:
     * - Return ProductOption data from storage for the given idProductAbstract
     *
     * @api
     *
     * @param int $idAbstractProduct
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ProductAbstractOptionStorageTransfer|null
     */
    public function getProductOptions($idAbstractProduct, $localeName);

    /**
     * Specification:
     * - Returns ProductOption data from storage for the given idProductAbstract
     * - Returns ProductOption only for CurrentStore
     *
     * @api
     *
     * @param int $idAbstractProduct
     *
     * @return \Generated\Shared\Transfer\ProductAbstractOptionStorageTransfer|null
     */
    public function getProductOptionsForCurrentStore($idAbstractProduct);

    /**
     * Specification:
     * - Returns an array of ProductAbstractOptionStorageTransfer indexed by idProductAbstract.
     *
     * @api
     *
     * @param array<int> $productAbstractIds
     *
     * @return array<\Generated\Shared\Transfer\ProductAbstractOptionStorageTransfer>
     */
    public function getBulkProductOptions(array $productAbstractIds): array;
}
