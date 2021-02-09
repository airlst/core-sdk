<?php


namespace AirLST\CoreSdk\Api\Workers\Traits;


/**
 * Trait AirLSTSoftDeleteResourceTrait
 *
 * @package AirLST\CoreSdk\Api\Workers\Traits
 *
 * @author Michael Thaller <m.thaller@airlst.com>
 */
trait AirLSTSoftDeleteResourceTrait
{
    use AirLSTCrudResourceTrait;

    /**
     * @param $id
     * @return array|null
     */
    public function archive($id): ?array
    {
        return $this->doRequest(
            $this->getCrudEntityPath($id),
            'DELETE',
            [
                'force' => false
            ]
        ) ? $this->extractDataFromLastResponse() : null;
    }

    /**
     * @param $id
     * @return array|null
     */
    public function restore($id): ?array
    {
        return $this->doRequest($this->getCrudEntityPath($id) . '/restore', 'PUT')
            ? $this->extractDataFromLastResponse()
            : null;
    }
}
