<?php

namespace DeveloperMode\Data\Objects;

use DeveloperMode\Services\ObjectProvider;

class DeveloperObject implements ObjectProvider
{

    const SCOREBOARD = 'scoreboard';

    /** @var bool */
    private $scoreboard;

    /**
     * @param bool $scoreboard
     */
    public function __construct(bool $scoreboard)
    {
        $this->scoreboard = $scoreboard;
    }

    /**
     * @param array $data
     * @return self
     */
    public static function toObject(array $data)
    {
        return new self($data[self::SCOREBOARD]);        
    }

    /**
     * @param bool $scoreboard
     * @return void
     */
    public function setScoreboard(bool $scoreboard)
    {
        $this->scoreboard = $scoreboard;
    }

    /**
     * @return bool
     */
    public function getScoreboard(): bool
    {
        return $this->scoreboard;        
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::SCOREBOARD => $this->scoreboard
        ];
    }
}
