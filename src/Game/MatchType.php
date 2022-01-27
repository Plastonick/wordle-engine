<?php

namespace Plastonick\WordleEngine\Game;

enum MatchType: string
{
    case NONE = '_';
    case PARTIAL = '~';
    case EXACT = '#';
}
