<?php

namespace App\Repositories;

use App\Data\PlanData;
use App\Data\PlanWithPlansData;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;

class StripePlanRepository
{
    public function __construct()
    {
        Stripe::setApiKey(config('cashier.secret'));
    }

    /**
     * アクティブな商品と価格を取得して PlanWithPlansData 配列で返す
     *
     * @return array<\App\Data\PlanWithPlansData>
     */
    public function getActivePlans(): array
    {
        $products = Product::all(['active' => true]);
        $productDtos = [];

        foreach ($products->data as $product) {
            $prices = Price::all([
                'product' => $product->id,
                'active' => true,
            ]);

            $plans = collect($prices->data)->map(function ($price) {
                return new PlanData(
                    $price->id,
                    $price->unit_amount,
                    $price->currency,
                    $price->recurring->interval ?? null
                );
            })->all();

            $productDtos[] = new PlanWithPlansData(
                $product->id,
                $product->name,
                $product->description,
                $plans
            );
        }

        return $productDtos;
    }
}
