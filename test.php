<?php

use Plastonick\WordleEngine\Game\Game;
use Plastonick\WordleEngine\Player\Human;

include 'vendor/autoload.php';

$words = explode("\n", file_get_contents(__DIR__ . '/words'));

// instantiate a new game with a word list, and two players

//var_dump(str_split('$word'));

$game = new Game($words, new Human());

echo "Ready to play!\n";
try {
    while ($result = $game->play()) {
        $result->shout();
    }
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
echo $game->target . PHP_EOL;
// players can either be computer or human players, should implement player interface


