<?php

namespace AirLST\CoreSdk\Api\Workers;

use AirLST\CoreSdk\Api\Abstracts\ApiWorker;

/**
 * Class ProfileWorker
 *
 * @package AirLST\CoreSdk\Api\Workers
 *
 * @author Michael Thaller <m.thaller@airlst.com>
 */
class ProfileWorker extends ApiWorker
{
    /**
     * @param  bool  $withCompany
     * @return array|null
     * @throws \Throwable
     */
    public function getProfile(bool $withCompany = false): ?array
    {
        $data = [];
        if ($withCompany) {
            $data['include'] = 'company';
        }

        if (!$this->doRequest('auth/profile', 'GET', $data)) {
            return null;
        }

        return $this->extractDataFromLastResponse();
    }
}
