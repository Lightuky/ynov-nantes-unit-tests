<?php

use PHPUnit\Framework\TestCase;

require_once('./src/flatten.php');

class FlattenTest extends TestCase
{
    public function test_empty()
    {
        $this->assertEquals([], flatten([]));
        $this->assertEquals([], flatten([[]]));
        $this->assertEquals([], flatten([[], [[], []]]));
    }

    public function test_types()
    {
        $this->expectException(TypeError::class);
        flatten(120);
        flatten(50.5);
        flatten("abc");
        flatten("790");
        flatten(null);
    }

    public function test_normal()
    {
        $this->assertEquals([8], flatten([8]));
        $this->assertEquals([8, 9, 7, 5], flatten([8, 9, 7, 5]));
        $this->assertEquals([8, -9, 7, 87, 66, 2, -5], flatten([8, -9, 7, [87, 66, 2, -5]]));
        $this->assertEquals([8, -9, 7, 87, 66, 2, 8, -77, 3, -5], flatten([8, -9, 7, [87, 66, [2, 8, -77, 3], -5]]));
    }
}