<?php

namespace AirLST\CoreSdk\Api\Workers;

use AirLST\CoreSdk\Api\Abstracts\ApiWorker;
use AirLST\CoreSdk\Api\Workers\Traits\AirLSTCrudResourceTrait;
use AirLST\CoreSdk\Api\Workers\Traits\HasFastPipeTrait;

/**
 * Class RsvpWorker
 *
 * @package AirLST\CoreSdk\Api\Workers
 *
 * @author Michael Thaller <m.thaller@airlst.com>
 */
class BbbRoomWorker extends ApiWorker
{
    use AirLSTCrudResourceTrait, HasFastPipeTrait;

    protected ?int $guestlistId = null;

    /**
     * @param  int  $roomId
     * @return array
     */
    public function getRsvpsForRoom(int $roomId): array
    {
        $curGuestlistId = $this->getGuestlistId();
        $this->setGuestlistId(null);
        $this->doRequest($this->getCrudEntityPath($roomId . '/rsvps'));

        $this->setGuestlistId($curGuestlistId);

        return $this->extractDataFromLastResponse();
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
     * @return BbbRoomWorker
     */
    public function setGuestlistId(?int $guestlistId): BbbRoomWorker
    {
        $this->guestlistId = $guestlistId;
        return $this;
    }

    /**
     * @param  int  $roomId
     * @param  int  $rsvpId
     * @param  array  $extraBbbParameters
     * @return array|null
     * @throws \Throwable
     */
    public function getRoomJoinUrlForRsvp(int $roomId, int $rsvpId, array $extraBbbParameters = []): ?array
    {
        $curGuestlistId = $this->getGuestlistId();
        $this->setGuestlistId(null);
        $this->doRequest(
            $this->getCrudEntityPath($roomId . '/join/' . $rsvpId),
            'POST',
            [
                'bbb_parameters' => $extraBbbParameters
            ]
        );

        $this->setGuestlistId($curGuestlistId);

        return $this->extractDataFromLastResponse();
    }

    /**
     * @return string
     */
    protected function getEntityPrefix(): string
    {
        return 'rooms';
    }

    /**
     * @return string
     */
    protected function getEntityFastPipePrefix(): string
    {
        if (!$this->getGuestlistId()) {
            return 'fp/rooms';
        } else {
            return 'fp/guestlists/' . $this->getGuestlistId() . '/rooms';
        }
    }
}
