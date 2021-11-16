<?php

namespace App;

use App\Models\Product;

class SmartSearch
{
    private static $ignoredWords = ['и', 'или', '%', 'в', 'для', 'с', 'около'];
    private static $countWords = [
        'шт.', 'шт', 'штук', 'штука', 'штуки',
        'п', 'п.', 'пач', 'пач.', 'пачек', 'пачка', 'пачки',
        'уп', 'уп.', 'упак', 'упак.', 'упаковка', 'упаковок', 'упаковки',
        'немного', 'пару', 'десяток', 'несколько', 'чуть-чуть', 'чуть чуть'
    ];

    private $keyPhrase;
    private $currentWord;

    /**
     * @param $keyPhrase
     */
    public function __construct($keyPhrase)
    {
        $this->keyPhrase = $keyPhrase;
    }

    public static function run(string $keyPhrase): array
    {
        $smartSearch = new SmartSearch($keyPhrase);
        return $smartSearch->privateRun();
    }

    private function privateRun(): array
    {
        $resultProducts = [];
        $keywords = explode(' ', $this->keyPhrase);
        $sortedKeywords = [];
        foreach ($keywords as $keyword) {
            $this->currentWord = $keyword;
            if ($this->isNotIgnored() && $this->isNotNumber() &&
                $this->isNotContainsPercent() && $this->isNotCountWord()) {
                array_push($sortedKeywords, $this->currentWord);
            }
        }

        $storedProducts = Product::all();
        foreach ($storedProducts as $storedProduct) {
            $words = explode(' ', $storedProduct->description);
            for ($i = 0; $i < 3; $i++) {
                if (in_array($words[$i], $sortedKeywords)) {
                    array_push($resultProducts, $storedProduct);
                    break;
                }
            }
        }

        return $resultProducts;
    }

    private function isNotIgnored(): bool
    {
        return !in_array($this->currentWord, self::$ignoredWords);
    }

    private function isNotNumber(): bool
    {
        return !is_numeric($this->currentWord);
    }

    private function isNotContainsPercent(): bool
    {
        return !str_contains($this->currentWord, '%');
    }

    private function isNotCountWord(): bool
    {
        return !in_array($this->currentWord, self::$countWords);
    }

}
