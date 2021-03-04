<?php

namespace AirLST\CoreSdk\Api\Workers;

use AirLST\CoreSdk\Api\Abstracts\ApiWorker;
use AirLST\CoreSdk\Api\Workers\Traits\AirLSTSoftDeleteResourceTrait;
use AirLST\CoreSdk\Api\Workers\Traits\HasFastPipeTrait;

/**
 * Class RsvpWorker
 *
 * @package AirLST\CoreSdk\Api\Workers
 *
 * @author Michael Thaller <m.thaller@airlst.com>
 */
class RsvpWorker extends ApiWorker
{
    use AirLSTSoftDeleteResourceTrait, HasFastPipeTrait;

    protected ?int $guestlistId = null;

    /**
     * @param $code
     * @return array|null
     * @throws \Throwable
     */
    public function findByCode($code): ?array
    {
        return $this->doRequest(
            'guestlists/'.$this->guestlistId.'/find-rsvp-by-code',
            'GET',
            [
                'code' => $code
            ]
        ) ? $this->extractDataFromLastResponse() : null;
    }

    /**
     * @return string
     */
    protected function getEntityPrefix(): string
    {
        return 'rsvps';
    }

    /**
     * @return string
     */
    protected function getEntityFastPipePrefix(): string
    {
        if (!$this->getGuestlistId()) {
            return 'fp/rsvps';
        } else {
            return 'fp/guestlists/' . $this->getGuestlistId() . '/rsvps';
        }
    }

    /**
     * @return int|null
     */
    public function getGuestlistId(): ?int
    {
        return $this->guestlistId;
    }

    /**
     * @param  int|null  $guestlistId
     * @return RsvpWorker
     */
    public function setGuestlistId(?int $guestlistId): RsvpWorker
    {
        $this->guestlistId = $guestlistId;
        return $this;
    }
}
