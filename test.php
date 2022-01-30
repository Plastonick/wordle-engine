<?php

use Plastonick\WordleEngine\Game\Game;
use Plastonick\WordleEngine\Game\State;
use Plastonick\WordleEngine\Player\Human;
use Plastonick\WordleEngine\Player\Playable;

include 'vendor/autoload.php';

$words = explode("\n", file_get_contents(__DIR__ . '/words'));

// instantiate a new game with a word list, and two players

//var_dump(str_split('$word'));

$game = new Game($words, new Human());

echo "Ready to play!\n";
try {
    $state = $game->play();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
echo $game->target . PHP_EOL;
// players can either be computer or human players, should implement player interface


