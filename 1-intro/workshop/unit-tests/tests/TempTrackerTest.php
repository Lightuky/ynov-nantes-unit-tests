<?php

use PHPUnit\Framework\TestCase;

require_once('./src/TempTracker.php');

class TempTrackerTest extends TestCase
{
    public function test_types()
    {
        $this->expectException(TypeError::class);
        $temp_tracker = new TempTracker();
        $temp_tracker->insert("string");
        $temp_tracker->insert("720");
        $temp_tracker->insert(50.8);
        $temp_tracker->insert(null);
    }

    public function test_extreme_values()
    {
        $this->expectException(ValueError::class);
        $temp_tracker = new TempTracker();
        $temp_tracker->insert(300);
        $temp_tracker->insert(-100);
    }

    public function test_min_value()
    {
        $temp_tracker = new TempTracker();
        $temp_tracker->insert(8);
        for ($i = 1; $i <= 10; $i++) {
            $temp_tracker->insert(rand(10,100));
        }
        $this->assertEquals(8, $temp_tracker->get_min());
    }

    public function test_max_value()
    {
        $temp_tracker = new TempTracker();
        $temp_tracker->insert(105);
        for ($i = 1; $i <= 10; $i++) {
            $temp_tracker->insert(rand(10,100));
        }
        $this->assertEquals(105, $temp_tracker->get_max());
    }
}