<?php

namespace App\Helpers;

class ColorHelper
{
    /**
     * Generate inline style for color display
     * 
     * @param string $color Color code (e.g., #FFFFFF)
     * @return string HTML inline style
     */
    public static function colorBoxStyle($color)
    {
        return "width: 25px; height: 25px; border-radius: 6px; background-color: " . $color;
    }
}
