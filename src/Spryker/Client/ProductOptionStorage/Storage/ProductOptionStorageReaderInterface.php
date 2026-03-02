<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductOptionStorage\Storage;

use Generated\Shared\Transfer\ProductAbstractOptionStorageTransfer;

interface ProductOptionStorageReaderInterface
{
    public function getProductOptions(int $idProductAbstract, string $localeName): ?ProductAbstractOptionStorageTransfer;

    public function getProductOptionsForCurrentStore(int $idProductAbstract): ?ProductAbstractOptionStorageTransfer;

    /**
     * @param array<int> $productAbstractIds
     *
     * @return array<\Generated\Shared\Transfer\ProductAbstractOptionStorageTransfer>
     */
    public function getBulkProductOptions(array $productAbstractIds): array;
}
