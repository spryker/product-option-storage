<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsUserConnector\Dependency\Facade;

class CmsUserConnectorToUserBridge implements CmsUserConnectorToUserInterface
{
    /**
     * @var \Spryker\Zed\User\Business\UserFacadeInterface
     */
    protected $userFacade;

    /**
     * @param \Spryker\Zed\User\Business\UserFacadeInterface $userFacade
     */
    public function __construct($userFacade)
    {
        $this->userFacade = $userFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function getCurrentUser()
    {
        return $this->userFacade->getCurrentUser();
    }

    /**
     * @return bool
     */
    public function hasCurrentUser()
    {
        return $this->userFacade->hasCurrentUser();
    }

    /**
     * @param int $idUser
     *
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function getUserById($idUser)
    {
        return $this->userFacade->getUserById($idUser);
    }
}
