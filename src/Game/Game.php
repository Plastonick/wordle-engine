<?php

namespace Plastonick\WordleEngine\Game;

use Exception;
use Plastonick\WordleEngine\Player\Playable;
use function array_intersect;
use function array_rand;
use function define;
use function in_array;
use function str_split;
use function strlen;

class Game
{
    public string $target; // todo make private
    private array $goes = [];

    public function __construct(private readonly array $words, private readonly Playable $player)
    {
        $this->target = $this->words[array_rand($this->words)];
    }

    /**
     * @throws Exception
     */
    public function play(): Result
    {
        $word = $this->player->play();

        if ($word === $this->target) {
            throw new Exception('You win!');
        }

        if (!$this->wordIsValid($word)) {
            throw new Exception('Word is not valid');
        }

        $matchingLetters = $this->matchingLetters($word);
        $targetLetters = str_split($this->target);

        $results = [];
        foreach (str_split($word) as $index => $char) {
            $matchType = match (true) {
                $char === $targetLetters[$index] => MatchType::EXACT,
                in_array($char, $matchingLetters) => MatchType::PARTIAL,
                default => MatchType::NONE,
            };

            $results[] = [$char, $matchType];
        }

        $this->goes[] = $word;

        if (count($this->goes) === 6) {
            throw new Exception('You lose!');
        }

        return new Result($results, count($this->goes));
    }

    private function wordIsValid(string $word): bool
    {
        if (strlen($word) !== 5) {
            return false;
        }

        if (!in_array($word, $this->words)) {
            return false;
        }

        return true;
    }

    private function matchingLetters(string $word): array
    {
        return array_intersect(
            str_split($word),
            str_split($this->target)
        );
    }
}
