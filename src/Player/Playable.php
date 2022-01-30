<?php

namespace Plastonick\WordleEngine\Player;

use Plastonick\WordleEngine\Game\State;

interface Playable
{
    public function setWordList(array $wordList): void;

    public function guess(State $state): string;
}
