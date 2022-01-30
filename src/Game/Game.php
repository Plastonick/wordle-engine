<?php

namespace Plastonick\WordleEngine\Game;

use Plastonick\WordleEngine\Exception\InvalidWord;
use Plastonick\WordleEngine\Player\Playable;
use function array_intersect;
use function array_rand;
use function in_array;
use function str_split;
use function strlen;
use const PHP_EOL;

class Game
{
    public string $target; // todo make private

    public function __construct(private readonly array $words, private readonly Playable $playable)
    {
        $this->target = $this->words[array_rand($this->words)];
        $this->playable->setWordList($this->words);
    }

    public function play(): State
    {
        $state = new State();

        while (!$state->isComplete) {
            $word = $this->playable->guess($state);

            if (!$word) {
                continue;
            }

            try {
                $result = $this->tryWord($word);
                $result->shout();

                $state = $state->withResult($result);
                switch (true) {
                    case $this->isSuccessful($word):
                        $state = $state->asSuccessful();
                    case $this->takenAllGoes($state):
                        $state = $state->asComplete();
                        break;
                }
            } catch (InvalidWord $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        }

        return $state;
    }

    /**
     * @param State $state
     *
     * @return bool
     */
    private function takenAllGoes(State $state): bool
    {
        return count($state->results) === 6;
    }

    /**
     * @param string $word
     *
     * @return bool
     */
    private function isSuccessful(string $word): bool
    {
        return $word === $this->target;
    }

    /**
     * @param string $word
     *
     * @return Result
     * @throws InvalidWord
     */
    private function tryWord(string $word): Result
    {
        if (!$this->wordIsValid($word)) {
            throw InvalidWord::forWord($word);
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

        return new Result($results);
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
