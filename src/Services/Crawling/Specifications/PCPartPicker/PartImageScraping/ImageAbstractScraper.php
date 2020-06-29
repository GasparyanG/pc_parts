<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Symfony\Component\DomCrawler\Crawler;

abstract class ImageAbstractScraper
{
    const REFERER = "referer";

    /**
     * Delay between requests
     * @var int
     */
    protected static $delay = 8000;

    /**
     * Meant for single resource.
     *
     * @var array
     */
    protected $single_resource_headers = [
        "authority" => "pcpartpicker.com",
        "upgrade-insecure-requests" => "1",
        "user-agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36",
        "accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "sec-fetch-site" => "same-origin",
        "sec-fetch-mode" => "navigate",
        "sec-fetch-user" => "?1",
        "sec-fetch-dest" => "document",
        "accept-language" => "en-US,en;q=0.9,hy-AM;q=0.8,hy;q=0.7,ru-RU;q=0.6,ru;q=0.5,la;q=0.4",
        "cookie" => "xcsrftoken=DQkGqCEtILSOWlANbIJGSoPj7U5kFKoe6IpOFbuvO4b18njVMnkR48E0AZym5V4w; "
            . "xgdpr-consent=allow; theme=light-mode; "
            . "xsessionid=lqcvep65fzh8eji6nc5cpr3e9t4wzp12; "
            . "__cfduid=d66736e21d329af7bbccdc3241a8b58961590753547"
    ];

    /**
     * @var string|null
     */
    protected static $name = null;

    /**
     * @var string|null
     */
    protected static $referer = null;

    /**
     * @var string
     */
    protected static $productsUrl = "https://pcpartpicker.com/products/";

    /**
     * @var Client
     */
    protected $client;

    protected static $selectors = [
        "#single_image_gallery_box img",
        "#gallery_box .gallery__images .gallery__image .gallery__imageWrapper img",
        "#gallery_box .gallery__image .gallery__imageWrapper img",
        "#gallery_box .gallery__image img",
    ];

    public function __construct()
    {
        $this->client = new Client();
    }

    protected static function getReferer(): string
    {
        return self::$productsUrl . static::$referer;
    }

    public function isUsed(string $part)
    {
        return $part === self::$name;
    }

    public function crawl(string $url, int $id): void
    {
        $urls = $this->urls($url);

        foreach ($urls as $imageUrl) {
            $fileName = $this->download($imageUrl);
            $this->persist($fileName, $id);
        }
    }

    protected function download(string $imageUrl): string
    {

    }

    protected function fileName(string $imageUrl): string
    {

    }

    protected function urls($url): array
    {
        echo $url . "\n";
        // prepare headers
        $this->single_resource_headers[self::REFERER] = self::getReferer();

        $request = new Request("GET", $url, $this->single_resource_headers);
        $response = $this->client->send($request, [RequestOptions::DELAY => self::$delay]);

        // scraping image urls
        $crawler = new Crawler((string)$response->getBody());
        $crawler = $crawler->filter("script")->reduce(function(Crawler $node) {
            $attribute = $node->extract(["type"]);
            if (isset($attribute["type"]) && $attribute["type"] == "text/javascript")
                return true;
        });

        $results = $crawler->each(function(Crawler $node) {
            return $node->text();
        });

        $overallString = "";
        foreach($results as $result) {
            $overallString .= $result;
        }

        return $this->prepareImageUrl($overallString);
    }

    protected function prepareImageUrl(string $overallString): array
    {
        if (!$overallString) return [];

        $pattern = '~src\s*:\s*(.{0,255}(\.jpg|\.png|.\jpeg)"),\s*thumb~imsx';
        $matches = [];
        preg_match_all($pattern, $overallString, $matches);

        if (isset($matches[1]) && $matches[1])
            return $matches[1];
        return [];
    }

    protected function desiredSelector(Crawler $crawler): ?string
    {
        foreach(self::$selectors as $selector)
            if ($crawler->matches($selector))
                return $selector;
        return null;
    }

    abstract public function persist(string $imageFileName, int $id): void;
}