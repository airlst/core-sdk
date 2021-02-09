<?php

namespace AirLST\CoreSdk\Api\Workers;

use AirLST\CoreSdk\Api\Abstracts\ApiWorker;
use AirLST\CoreSdk\Api\Workers\Traits\AirLSTSoftDeleteResourceTrait;
use AirLST\CoreSdk\Api\Workers\Traits\HasFastPipeTrait;

/**
 * Class GuestlistWorker
 *
 * @package AirLST\CoreSdk\Api\Workers
 *
 * @author Michael Thaller <m.thaller@airlst.com>
 */
class GuestlistWorker extends ApiWorker
{
    use AirLSTSoftDeleteResourceTrait, HasFastPipeTrait;

    /**
     * @return string
     */
    protected function getEntityPrefix(): string
    {
        return 'guestlists';
    }

    /**
     * @return string
     */
    protected function getEntityFastPipePrefix(): string
    {
        return 'fp/guestlists';
    }
}
