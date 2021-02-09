<?php

namespace AirLST\CoreSdk;

use Illuminate\Support\Arr;

/**
 * Class Webhooks
 *
 * @package AirLST\CoreSdk
 *
 * @author Michael Thaller <m.thaller@airlst.com>
 */
class Webhook
{
    /**
     * @var array
     */
    private $requestBody;

    /**
     * Webhook constructor.
     * @param  array  $requestBody
     */
    public function __construct(array $requestBody)
    {
        $this->requestBody = $requestBody;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $requestHash = Arr::get($this->requestBody, 'secret');

        if (!$requestHash) {
            return false;
        }

        $signInformation = Arr::only($this->requestBody, ['try', 'event']);

        $newHash = crypt(
            json_encode($this->sortDataForHashing($signInformation)),
            config('airlst-sdk.webhooks.secret')
        );

        return hash_equals($requestHash, $newHash);
    }

    /**
     * @param  array  $dataToSort
     * @return array
     */
    private function sortDataForHashing(array $dataToSort): array
    {
        ksort($dataToSort);
        foreach ($dataToSort as $key => $value) {
            if (is_array($value)) {
                $dataToSort[$key] = $this->sortDataForHashing($value);
            }
        }

        return $dataToSort;
    }

    /**
     * @return array
     */
    public function getEventInformation():array {
        return (array) Arr::get($this->requestBody, 'event', []);
    }

    /**
     * @return array
     */
    public function getRequestBody():array {
        return $this->requestBody;
    }
}
