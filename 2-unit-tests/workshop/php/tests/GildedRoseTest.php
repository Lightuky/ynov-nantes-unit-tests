<?php

declare(strict_types=1);

namespace Tests;

use ArgumentCountError;
use GildedRose\GildedRose;
use GildedRose\Item;
use phpDocumentor\Reflection\Types\Void_;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testNoItems(): void
    {
        $this->expectException(ArgumentCountError::class);
        $gildedRose = new GildedRose();
        $gildedRose->updateQuality();
    }

    public function testMissingAttributes(): void
    {
        $this->expectException(ArgumentCountError::class);
        $incomplete_items = [
            new Item(name: 'Missing Attribute Item 1', sell_in: 5),
            new Item(sell_in: 5, quality: 14),
            new Item(quality: 8),
            new Item(),
        ];
        $gildedRose = new GildedRose($incomplete_items);
        $gildedRose->updateQuality();
    }

    public function testNormalAttributesDecrease(): void
    {
        $items_data = [
            ["sell_in" => 5, "quality" => 10],
            ["sell_in" => 10, "quality" => 9],
            ["sell_in" => 7, "quality" => 8],
            ["sell_in" => 9, "quality" => 7],
        ];
        foreach ($items_data as $item_data) {
            $item = [new Item("Item", $item_data['sell_in'], $item_data['quality'])];
            $gildedRose = new GildedRose($item);
            $gildedRose->updateQuality();
            $this->assertSame($item_data['quality'] - 1, $item[0]->quality);
            $this->assertSame($item_data['sell_in'] - 1, $item[0]->sell_in);
        }
    }

    public function testExpiredItemQualityDrop(): void
    {
        $expired_item = [new Item('Expired', -1, 5)];
        $gildedRose = new GildedRose($expired_item);
        $gildedRose->updateQuality();
        $this->assertSame(3, $expired_item[0]->quality);
    }

    public function testNegativeQuality(): void
    {
        $zero_quality_item = [new Item('Zero Quality', 5, 0)];
        $gildedRose = new GildedRose($zero_quality_item);
        $gildedRose->updateQuality();
        $this->assertSame(0, $zero_quality_item[0]->quality);
    }

    public function testAgedBrieQualityIncrease(): void
    {
        $aged_brie = [new Item('Aged Brie', 5, 5)];
        $gildedRose = new GildedRose($aged_brie);
        $gildedRose->updateQuality();
        $this->assertSame(6, $aged_brie[0]->quality);
    }

    public function testMaxQualityAtFifty(): void
    {
        $max_quality_item = [new Item('Aged Brie', 5, 50)];
        $gildedRose = new GildedRose($max_quality_item);
        $gildedRose->updateQuality();
        $this->assertSame(50, $max_quality_item[0]->quality);
    }

    public function testSulfurasAttributesChanges(): void
    {
        $sulfuras = [new Item('Sulfuras, Hand of Ragnaros', 0, 99)];
        $gildedRose = new GildedRose($sulfuras);
        $gildedRose->updateQuality();
        $this->assertSame(99, $sulfuras[0]->quality);
        $this->assertSame(0, $sulfuras[0]->sell_in);
    }

    public function testBrieAndBackstageQualityIncrease(): void
    {
        $items_values = [
            ["sell_in" => 10, "expected_quality" => 12],
            ["sell_in" => 7, "expected_quality" => 12],
            ["sell_in" => 5, "expected_quality" => 13],
            ["sell_in" => 3, "expected_quality" => 13],
            ["sell_in" => -1, "expected_quality" => 0],
        ];
        foreach ($items_values as $item_values) {
            $backstage_passes = [new Item('Backstage passes to a TAFKAL80ETC concert', $item_values['sell_in'], 10)];
            $gildedRose = new GildedRose($backstage_passes);
            $gildedRose->updateQuality();
            $this->assertSame($item_values['expected_quality'], $backstage_passes[0]->quality);
        }
    }

    public function testConjuredItemQualityDecrease(): void
    {
        $products_names = [
            ["name" => "Conjured Item", "expected_quality" => 8],
            ["name" => "ConjuredItem", "expected_quality" => 9],
            ["name" => "item Conjured", "expected_quality" => 9],
            ["name" => "itemConjured", "expected_quality" => 9],
        ];

        foreach ($products_names as $product_name) {
            $conjured_item = [new Item($product_name['name'], 7, 10),];
            $gildedRose = new GildedRose($conjured_item);
            $gildedRose->updateQuality();
            $this->assertSame($product_name['expected_quality'], $conjured_item[0]->quality);
        }
    }
}
