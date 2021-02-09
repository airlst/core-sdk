<?php


namespace AirLST\CoreSdk\Api\Workers\Traits;


/**
 * Trait AirLSTCrudResourceTrait
 *
 * @package AirLST\CoreSdk\Api\Workers\Traits
 *
 * @author Michael Thaller <m.thaller@airlst.com>
 */
trait AirLSTCrudResourceTrait
{

    /**
     * @param $id
     * @return array|null
     */
    public function find($id): ?array
    {
        return $this->doRequest($this->getCrudEntityPath($id)) ? $this->extractDataFromLastResponse() : null;
    }

    /**
     * @param  string  $path
     * @return string
     */
    protected function getCrudEntityPath(string $path = ''): string
    {
        return rtrim($this->getEntityPrefix(), '/') . '/' . ltrim($path, '/');
    }

    /**
     * @return string
     */
    abstract protected function getEntityPrefix(): string;

    /**
     * @param $id
     * @param  array  $dataForUpdate
     * @return array|null
     */
    public function update($id, array $dataForUpdate): ?array
    {
        return $this->doRequest($this->getCrudEntityPath($id), 'PUT', $dataForUpdate)
            ? $this->extractDataFromLastResponse()
            : null;
    }

    /**
     * @param  array  $dataForUpdate
     * @return array|null
     */
    public function create(array $dataForUpdate): ?array
    {
        return $this->doRequest($this->getCrudEntityPath(), 'POST', $dataForUpdate)
            ? $this->extractDataFromLastResponse()
            : null;
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id): bool
    {
        return $this->doRequest(
            $this->getCrudEntityPath($id),
            'DELETE',
            [
                'force' => true
            ]
        ) ? true : false;
    }
}
