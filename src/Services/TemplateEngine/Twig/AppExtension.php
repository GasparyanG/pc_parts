<?php


namespace App\Services\TemplateEngine\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction("productName", [$this, "getProductName"])
        ];
    }

    public function getProductName(array $data): string
    {
        return $data["data"]["attributes"]["name"];
    }
}