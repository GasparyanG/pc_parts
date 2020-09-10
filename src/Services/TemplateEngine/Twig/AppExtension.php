<?php


namespace App\Services\TemplateEngine\Twig;


use App\Services\Model\PartsGuru\PartGuruFactory;
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

    public function getProductName(array $data, string $entityName): ?string
    {
        $partGuru = PartGuruFactory::create($entityName);
        if ($partGuru)
            return $partGuru->productName($data);
        else return null;
    }
}