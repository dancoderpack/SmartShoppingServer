<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $description
 * @property mixed $rate_details
 * @property mixed $research_document
 * @property mixed $disadvantages
 * @property mixed $price
 * @property mixed $barcode
 * @property mixed $advantages
 * @property mixed $details
 * @property mixed $image
 * @property mixed $rate
 */
class Product extends Model
{

    /**
     * @var bool
     */
    public $hideFullInfo = false;

    /**
     * @var int
     */
    public $searchRating = 0;

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function get($id)
    {
        return self::query()->find($id);
    }

    /**
     * @param $product
     * @return bool wasUpdated?
     */
    public static function add($product): bool
    {
        $db_product = self::query()->where('title', $product['title']);
        if ($db_product->exists()) {
            $db_product->update($product);
            return true;
        }
        $db_product->insert($product);
        return false;
    }

    /**
     * @param $barcode string
     * @return Builder|Model|object|null
     */
    public static function getByBarcode(string $barcode)
    {
        return self::query()->where('barcode', $barcode)->first();
    }

    /**
     * DEPRECATED
     * @param string $keyword
     * @return Builder[]|Collection
     */
    public static function search(string $keyword)
    {
        $products = self::query()
            ->where('title', 'LIKE', "%$keyword%")
            ->limit(20)
            ->get();
        foreach ($products as $product) {
            $product->hideFullInfo = true;
        }
        return $products;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $base_info = [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'rate' => $this->rate,
            'price' => $this->price
        ];

        return $this->hideFullInfo ? $base_info :
            $base_info + [
                'description' => $this->description,
                'rate_details' => json_decode($this->rate_details),
                'research_document' => $this->research_document,
                'advantages' => json_decode($this->advantages),
                'disadvantages' => json_decode($this->disadvantages),
                'details' => json_decode($this->details),
                'barcode' => $this->barcode
            ];
    }

}
