<?php

class TempTracker
{
    private array $temps;
    private int $min_temp;
    private int $max_temp;
    private int $mean_temp;
    private bool $uptodate_mean_temp;

    public function __construct()
    {
        $this->temps = [];
        $this->min_temp = -1;
        $this->max_temp = -1;
        $this->mean_temp = -1;
        $this->uptodate_mean_temp = false;
    }

    public function insert($temp)
    {
        if (!is_int($temp)) {
            throw new TypeError('parameter should be an int');
        }
        if ($temp < 0 || $temp > 110) {
            throw new ValueError('parameter should be within [0..110]');
        }

        # if current temperature is lower than the last recorded, save it
        if ($this->min_temp == -1 || $temp < $this->min_temp) {
            $this->min_temp = $temp;
        }

        # if current temperature is higher than the last recorded, save it
        if ($this->max_temp == -1 || $temp > $this->max_temp) {
            $this->max_temp = $temp;
        }

        # as we have inserted new element, our mean have changed
        $this->uptodate_mean_temp = false;

        $this->temps[] = $temp;
    }

    public function get_min(): int
    {
        return $this->min_temp;
    }

    public function get_max(): int
    {
        return $this->max_temp;
    }

    public function get_temps(): array
    {
        return $this->temps;
    }

    public function get_mean(): float|int
    {
        if ($this->uptodate_mean_temp) {
            return $this->mean_temp;
        }
        if (count($this->temps) == 0) {
            throw new ValueError('no temperature recorded');
        }
        $sum_of_temps = 0;
        foreach ($this->temps as $temp) {
            $sum_of_temps = $sum_of_temps + $temp;
        }

        # register this calculation to avoid doing it too often
        $this->mean_temp = $sum_of_temps / count($this->temps);
        $this->uptodate_mean_temp = true;
        return $this->mean_temp;
    }

}