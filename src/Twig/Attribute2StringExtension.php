<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Attribute2StringExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('attribute2String', [$this, 'convertArrayToString']),
        ];
    }

    public function convertArrayToString(array $value): string
    {
        $result = '';
        foreach ($value as $key => $val) {
            $result .= $key . '="' . $val . '" ';
        }
        return trim($result);
    }
}
