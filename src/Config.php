<?php

namespace Cleantekker;

use Noodlehaus\AbstractConfig;

class Config extends AbstractConfig
{
    /**
     * Constructor method and sets default options, if any
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $filteredData = array_filter(array_merge($this->getDefaults(), $data));
        parent::__construct($filteredData);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaults()
    {
        return [
            'key'     => null,
            'token'   => null,
            'scheme'  => 'https',
            'host'    => 'api.domain.com',
            'version' => 'v1',
        ];
    }
}