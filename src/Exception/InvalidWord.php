<?php

namespace Plastonick\WordleEngine\Exception;

use Exception;

class InvalidWord extends Exception
{
    public static function forWord(string $word)
    {
        return new self("'{$word}' is not a valid word");
    }
}
