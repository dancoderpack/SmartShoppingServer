<?php

namespace App\Http\Controllers;

use App\Error;
use App\Models\Product;
use App\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    /**
     * @param $id
     * @return JsonResponse
     */
    public function get($id): JsonResponse
    {
        $product = Product::get($id);
        if ($product) return Response::create($product);
        return Response::create(Error::getByCode(Error::PRODUCT_NOT_FOUND));
    }

    /**
     * @param $barcode string
     * @return JsonResponse
     */
    public function getByBarcode(string $barcode): JsonResponse
    {
        $product = Product::getByBarcode($barcode);
        if ($product) return Response::create($product);
        return Response::create(Error::getByCode(Error::PRODUCT_NOT_FOUND));
    }

    public function search(string $keyword): JsonResponse
    {
        $products = Product::search($keyword);
        if ($products) return Response::create($products);
        return Response::create(Error::getByCode(Error::PRODUCT_NOT_FOUND));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $insertingProduct = $request->toArray();
        foreach (['rate_details', 'advantages', 'disadvantages', 'details'] as $key)
            $insertingProduct[$key] = json_encode($insertingProduct[$key]);
        $wasUpdated = Product::add($insertingProduct);
        return Response::create(['message' => 'Товар успешно ' . ($wasUpdated ? 'обновлен!' : 'добавлен!')]);
    }

}
