<?php

namespace AirLST\CoreSdk\Facades;

use AirLST\CoreSdk\Api\Workers\ContactWorker;
use AirLST\CoreSdk\Api\Workers\GuestlistWorker;
use AirLST\CoreSdk\Api\Workers\RsvpWorker;
use Illuminate\Support\Facades\Facade;

/**
 * Class AirLSTCoreApi
 *
 * @package AirLST\CoreSdk\Facades
 *
 * @author Michael Thaller <m.thaller@airlst.com>
 *
 * @method static GuestlistWorker guestlist()
 * @method static RsvpWorker rsvp()
 * @method static ContactWorker contact()
 */
class AirLSTCoreApi extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'airlst.core-api'; }
}
