<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductOptionStorage\Price;

use Generated\Shared\Transfer\ProductAbstractOptionStorageTransfer;

interface ValuePriceReaderInterface
{
    public function resolveProductAbstractOptionStorageTransferProductOptionValuePrices(
        ProductAbstractOptionStorageTransfer $productAbstractOptionStorageTransfer
    ): ProductAbstractOptionStorageTransfer;

    /**
     * @param array<\Generated\Shared\Transfer\ProductAbstractOptionStorageTransfer> $productAbstractOptionStorageTransfers
     *
     * @return array<\Generated\Shared\Transfer\ProductAbstractOptionStorageTransfer>
     */
    public function resolveProductAbstractOptionStorageTransfersProductOptionValuePrices(
        array $productAbstractOptionStorageTransfers
    ): array;
}
