<?php

namespace Plastonick\WordleEngine\Player;


use Plastonick\WordleEngine\Game\State;

class Human implements Playable
{
    public function setWordList(array $wordList): void
    {
    }

    public function guess(State $state): string
    {
        $f = popen('read; echo $REPLY', "r");
        $input = fgets($f, 100);
        pclose($f);

        return trim($input);
    }
}
