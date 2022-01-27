<?php

namespace Plastonick\WordleEngine\Player;

interface Playable
{
    public function setWordList(array $wordList): void;

    public function play(): string;
}
