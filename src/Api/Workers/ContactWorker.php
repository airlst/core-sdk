<?php

namespace AirLST\CoreSdk\Api\Workers;

use AirLST\CoreSdk\Api\Abstracts\ApiWorker;
use AirLST\CoreSdk\Api\Workers\Traits\AirLSTSoftDeleteResourceTrait;
use AirLST\CoreSdk\Api\Workers\Traits\HasFastPipeTrait;

/**
 * Class ContactWorker
 *
 * @package AirLST\CoreSdk\Api\Workers
 *
 * @author Michael Thaller <m.thaller@airlst.com>
 */
class ContactWorker extends ApiWorker
{
    use AirLSTSoftDeleteResourceTrait, HasFastPipeTrait;

    /**
     * @return string
     */
    protected function getEntityPrefix(): string
    {
        return 'contacts';
    }

    /**
     * @return string
     */
    protected function getEntityFastPipePrefix(): string
    {
        return 'fp/contacts';
    }
}
