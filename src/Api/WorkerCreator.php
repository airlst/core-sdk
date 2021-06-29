<?php

namespace AirLST\CoreSdk\Api;

use AirLST\CoreSdk\Api\Abstracts\ApiWorker;
use AirLST\CoreSdk\Api\Exceptions\WorkerNotFoundException;
use AirLST\CoreSdk\Api\Workers\BbbRoomWorker;
use AirLST\CoreSdk\Api\Workers\ContactWorker;
use AirLST\CoreSdk\Api\Workers\GuestlistWorker;
use AirLST\CoreSdk\Api\Workers\ProfileWorker;
use AirLST\CoreSdk\Api\Workers\RsvpWorker;
use Illuminate\Support\Arr;

/**
 * Class WorkerCreator
 *
 * @package AirLST\CoreSdk\Api
 *
 * @author Michael Thaller <m.thaller@airlst.com>
 */
class WorkerCreator
{
    protected array $availableWorkers = [
        'guestlist' => GuestlistWorker::class,
        'rsvp' => RsvpWorker::class,
        'contact' => ContactWorker::class,
        'bbbRooms' => BbbRoomWorker::class,
        'profile' => ProfileWorker::class,
    ];

    /**
     * @param $name
     * @param $arguments
     *
     * @return ApiWorker
     * @throws WorkerNotFoundException
     */
    public function __call($name, $arguments)
    {
        throw_unless(
            ! Arr::has($this->availableWorkers, $name),
            WorkerNotFoundException::class,
            "No worker for key $name was found"
        );
    
        $className = Arr::get($this->availableWorkers, $name);
    
        /** @var ApiWorker $newInstance */
        $newInstance = new $className(...$arguments);
    
        if($token = config('airlst-sdk.api.auth_token')) {
            $newInstance->setAuthorizationToken($token);
        }
    
        return $newInstance;
    }
}
