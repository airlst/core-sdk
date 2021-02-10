<?php

namespace AirLST\CoreSdk\Api\Workers\Traits;


/**
 * Trait HasFastPipeTrait
 *
 * @package AirLST\CoreSdk\Api\Workers\Traits
 *
 * @author Michael Thaller <m.thaller@airlst.com>
 */
trait HasFastPipeTrait
{

    /**
     * @param  array  $fields
     * @param  array  $filters
     * @param  array  $sort
     * @param  array  $pagination
     * @param  array  $extendedRootData
     * @return array|null
     */
    public function getFpList(
        array $fields = ['id'],
        array $filters = [],
        array $sort = ['id' => 'asc'],
        array $pagination = ['perPage' => 25, 'page' => 1],
        array $extendedRootData = []
    ): ?array {
        if (!$this->doRequest(
            $this->getEntityFastPipePath(),
            'POST',
            array_merge([
                'fields' => $fields,
                'filters' => $filters,
                'sort' => $sort,
                'pagination' => $pagination
            ], $extendedRootData)
        )) {
            return null;
        };

        return $this->extractDataFromLastResponse(true);
    }

    /**
     * @param  string  $path
     * @return string
     */
    protected function getEntityFastPipePath(string $path = ''): string
    {
        return rtrim($this->getEntityFastPipePrefix(), '/') . '/' . ltrim($path, '/');
    }

    /**
     * @return string
     */
    abstract protected function getEntityFastPipePrefix(): string;

    /**
     * @return array|null
     */
    public function getFpListDefinition(): ?array
    {
        if (!$this->doRequest(
            $this->getEntityFastPipePath('definition'),
            'GET',
        )) {
            return null;
        };

        return $this->extractDataFromLastResponse(true);
    }

}
