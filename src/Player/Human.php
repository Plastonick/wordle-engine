<?php

namespace Plastonick\WordleEngine\Player;

use function var_dump;
use const PHP_EOL;

class Human implements Playable
{
    public function setWordList(array $wordList): void
    {
    }

    public function play(): string
    {
        $f = popen('read; echo $REPLY', "r");
        $input = fgets($f, 100);
        pclose($f);

        return trim($input);
    }
}
