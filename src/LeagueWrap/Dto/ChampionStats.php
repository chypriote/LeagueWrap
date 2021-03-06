<?php

namespace LeagueWrap\Dto;

class ChampionStats extends AbstractDto
{
    use ImportStaticTrait;

    protected $staticFields = [
        'id' => 'champion',
    ];

    /**
     * @param array $info
     */
    public function __construct(array $info)
    {
        if (isset($info['stats'])) {
            $info['stats'] = new AggregateStats($info['stats']);
        }
        parent::__construct($info);
    }
}
