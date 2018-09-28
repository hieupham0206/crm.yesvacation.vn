<?php

namespace App\Traits\Core;

trait Linkable
{
    /**
     * @param string $text
     * @param string $font
     *
     * @return string
     */
    public function getViewLink($text = '', $font = 'brand')
    {
        $modelValName = $text ?? $this->{$this->displayAttribute};

        $route = route("{$this->route}.show", $this);

        return "<a target='_blank' class='m-link m--font-bolder m--font-{$font}' href='$route'>$modelValName</a>";
    }

    /**
     * @param string $text
     * @param string $font
     *
     * @return string
     */
    public function getEditLink($text = '', $font = 'brand')
    {
        $modelValName = $text ?? $this->{$this->displayAttribute};

        $route = route("{$this->route}.edit", $this);

        return "<a target='_blank' class='m-link m--font-bolder m--font-{$font}' href='$route'>$modelValName</a>";
    }
}