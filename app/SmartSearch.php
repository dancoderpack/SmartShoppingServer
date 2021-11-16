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

    public static function run(string $keyPhrase)
    {
        $smartSearch = new SmartSearch(mb_strtolower($keyPhrase));
        return $smartSearch->privateRun();
    }

    private function privateRun()
    {
        $keywords = explode(' ', $this->keyPhrase); //Разбиваем запрос на ключевые слова
        $sortedKeywords = $this->getSortedKeywords($keywords); //Оставляем те, что подходят под условия

//        $storedProducts = Product::all(); //Получаем все продукты с базы данных
//        foreach ($storedProducts as $storedProduct) {
//            $descriptionWords = explode(' ', mb_strtolower($storedProduct->description));
//
//            foreach ($sortedKeywords as $keyword) {
//                for ($i = 0; $i < 2; $i++) {
//                    $croppedDescriptionWord = mb_substr($descriptionWords[$i], 0, -1);
//                    if (str_contains($keyword, $croppedDescriptionWord)) {
//                        $storedProduct->hideFullInfo = true;
//                        array_push($resultProducts, $storedProduct);
//                        break 2;
//                    }
//                }
//            }
//        }

        $query = Product::query();
        $counter = 0;
        foreach ($sortedKeywords as $keyword) {
            if ($counter == 0) {
                $query = $query->where('title', 'LIKE', "%$keyword%");
            } else {
                $query = $query->orWhere('title', 'LIKE', "%$keyword%");
            }
            $counter += 1;
        }

        $resultProducts = $query->get();
        foreach ($resultProducts as $product) {
            $product->hideFullInfo = true;
        }

        return $resultProducts;
    }

    private function getSortedKeywords($keywords): array
    {
        $sortedKeywords = [];
        foreach ($keywords as $keyword) {
            $this->currentWord = $keyword;
            if ($this->isNotIgnored() && $this->isNotNumber() &&
                $this->isNotContainsPercent() && $this->isNotCountWord() &&
                strlen($this->currentWord) > 3) {
                array_push($sortedKeywords, $this->currentWord);
            }
        }
        return $sortedKeywords;
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
