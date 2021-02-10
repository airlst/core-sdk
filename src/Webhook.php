<?php

namespace AirLST\CoreSdk;

use Illuminate\Http\Request;
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
     * @var Request
     */
    private Request $request;

    /**
     * Webhook constructor.
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $requestSignature = $this->request->header('x-airlst-webhook-signature');

        if (!$requestSignature) {
            return false;
        }

        $mySignature = hash_hmac(
            'sha256',
            $this->request->getContent(),
            config('airlst-sdk.webhooks.secret')
        );

        return $requestSignature === $mySignature;
    }

    /**
     * @return array
     */
    public function getEventInformation(): array
    {
        return (array) $this->request->get('event');
    }

    /**
     * @return array
     */
    public function getRequestBody(): array
    {
        return $this->request->all();
    }
}
