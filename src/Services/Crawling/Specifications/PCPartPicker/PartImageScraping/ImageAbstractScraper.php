<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping;


use App\Database\Connection;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Symfony\Component\DomCrawler\Crawler;

abstract class ImageAbstractScraper
{
    const REFERER = "referer";

    /**
     * Images directory
     * @var string
     */
    public static $image_directory = __DIR__ . "/../../../../../../public/photos/product";

    /**
     * Delay between requests
     * @var int     in milliseconds
     */
    protected static $delay = 8000;

    /**
     * Delay between image download
     * @var int     in seconds
     */
    protected static $imageDelay = 5;

    /**
     * Meant for single resource.
     *
     * @var array
     */
    protected $single_resource_headers = [
        "authority" => "pcpartpicker.com",
        "upgrade-insecure-requests" => "1",
        "user-agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36",
        "accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "sec-fetch-site" => "same-origin",
        "sec-fetch-mode" => "navigate",
        "sec-fetch-user" => "?1",
        "sec-fetch-dest" => "document",
        "accept-language" => "en-US,en;q=0.9,hy-AM;q=0.8,hy;q=0.7,ru-RU;q=0.6,ru;q=0.5,la;q=0.4",
        "cookie" => "xcsrftoken=DQkGqCEtILSOWlANbIJGSoPj7U5kFKoe6IpOFbuvO4b18njVMnkR48E0AZym5V4w; "
            . "xgdpr-consent=allow; theme=light-mode; "
            . "xsessionid=lqcvep65fzh8eji6nc5cpr3e9t4wzp12; "
            . "cf_clearance=4a86cf7722dc5d00bebf8d61c8aec2d98d4ff166-1598877291-0-1z449b3e55zb0507712zb009c34-150; "
            . "__cfduid=db5c01007c90d1b6f19bf528885c59efa1598877291 "
    ];

    protected $image_headers = [
        'Origin' =>  "http://cdn.pcpartpicker.com",
        "Cache-Control" => "max-age=0",
        "upgrade-insecure-requests" => "1",
        "Connection" => "keep-alive",
        "user-agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36",
        "Content-Type" => "application/x-www-form-urlencoded",
        "accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-language" => "en-US,en;q=0.9,hy-AM;q=0.8,hy;q=0.7,ru-RU;q=0.6,ru;q=0.5,la;q=0.4",
        "cookie" => "xcsrftoken=DQkGqCEtILSOWlANbIJGSoPj7U5kFKoe6IpOFbuvO4b18njVMnkR48E0AZym5V4w; "
            . "xgdpr-consent=allow; theme=light-mode; "
            . "xsessionid=lqcvep65fzh8eji6nc5cpr3e9t4wzp12; "
            . "cf_clearance=4a86cf7722dc5d00bebf8d61c8aec2d98d4ff166-1598877291-0-1z449b3e55zb0507712zb009c34-150; "
            . "__cfduid=db5c01007c90d1b6f19bf528885c59efa1598877291 "
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

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct()
    {
        $this->client = new Client();
        $this->em = Connection::getEntityManager();
    }

    protected static function getReferer(): string
    {
        return self::$productsUrl . static::$referer;
    }

    public function isUsed(string $part): bool
    {
        return $part === static::$name;
    }

    /**
     * Download with already processed (image pure urls) urls.
     *
     * @param array $urls
     * @param int $id
     */
    public function downloadWithUrlsAndPersist(array $urls, int $id): void
    {
        foreach ($urls as $url) {
            // download
            $filename = $this->download($url, true);
            if (!$filename) continue;
            // persist
            $this->persist($filename, $id);
        }
    }

    public function crawl(string $url, int $id): void
    {
        $urls = $this->urls($url);

        foreach ($urls as $imageUrl) {
            // Imitate human interaction
            sleep(self::$imageDelay);
            // file preparation
            $fileName = $this->download($imageUrl);
            if (!$fileName) continue;
            // persisting to database
            $this->persist($fileName, $id);
        }
    }

    /**
     * @param string $imageUrl
     * @param bool $simple          Don't try to do anything smart, just rely on provided arguments
     * @return string|null
     */
    protected function download(string $imageUrl, bool $simple = false): ?string
    {
        if ($simple) {
            $urlToDownload = $imageUrl;
            // TODO: make extension dynamic like url's extension.
            $fileName = hash("md5", time()) . ".jpg";
        } else {
            $fileName = $this->fileName($imageUrl);
            if (!$fileName) return null;

            // download
            // there are some urls, which contain https prefix
            $http = $this->isHttp($imageUrl) ? "http:": "https:";
            $urlToDownload = $http . str_replace(["https:", '"https', '"', "http:"], "", $imageUrl);
        }

        file_put_contents(self::$image_directory . "/" . $fileName, file_get_contents($urlToDownload));

        return $fileName;
    }

    protected function fileName(string $imageUrl): ?string
    {
        [$crawledFileName, $extension] = $this->extractFileName($imageUrl);
        if (!$crawledFileName || !$extension) return null;

        $withoutHash = $crawledFileName . "_" . time();

        // hashing
        $hashedName = hash("md5", $withoutHash);

        // Name with extension
        // Extension contains dot (.)
        return $hashedName . $extension;
    }

    protected function extractFileName(string $imageUrl): array
    {
        $pattern = "~.+/images/(product|I)/(.+)(\.jpg|\.png|\.jpeg)~i";
        $matches = [];

        preg_match($pattern, $imageUrl, $matches);
        if ($matches)
            return [$matches[2], $matches[3]];
        return [null, null];
    }

    protected function urls($url): array
    {
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

    abstract public function persist(string $imageFileName, int $id): void;

    protected function isHttp($url): bool
    {
        $pattern = "~http://.+/images/(product|I)/(.+)(\.jpg|\.png|\.jpeg)~i";
        $matches = [];

        preg_match($pattern, $url, $matches);
        if ($matches)
            return true;
        return false;
    }

    public function imageIsRequired(int $entityId): bool
    {
        $em = Connection::getEntityManager();
        $entity = $em->getRepository(static::$name)->find($entityId);

        $methodName = (static::$name)::IMAGE_METHOD;
        if (count($entity->$methodName()) > 0) return false;
        return true;
    }
}