<?php

namespace Plastonick\WordleEngine\Game;

class Result
{
    public function __construct(private readonly array $results, private readonly int $go)
    {
    }

    public function shout(): void
    {
        echo $this->go . ' - ';

        foreach ($this->results as list($char, $matchType)) {
            switch ($matchType) {
                case MatchType::NONE;
                    echo "\033[90m";
                    break;
                case MatchType::PARTIAL;
                    echo "\033[33m";
                    break;
                case MatchType::EXACT;
                    echo "\033[32m";
                    break;
            }

            echo $char;
        }

        echo "\033[0m\n";
    }
}
