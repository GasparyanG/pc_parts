<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartScraping;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractScraping
{
    const RESULT = "result";
    const HTML = "html";

    static $baseUrl = "https://pcpartpicker.com";
    static $collectionUrl = "";
    static $enumNamespace = "";

    /**
     * @var array
     */
    protected $collection_page_headers;

    /**
     * @var array
     */
    protected $request_form_params;

    /**
     * @var array
     */
    static $XPaths = [];

    /**
     * @var int
     */
    static $delay = 8000;

    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    protected function extract_scalar_type(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter("p")->text();
        } catch (\InvalidArgumentException $e) {
            echo $e->getMessage() . '\n';
            return null;
        }
    }

    protected function extract_list_type(Crawler $crawler): ?array
    {
        try {
            $crawler = $crawler->filter("ul  > li");
            return $crawler->each(function (Crawler $node) {
                return $node->text();
            });
        } catch(\InvalidArgumentException $e) {
            return null;
        }
    }

    protected function extract_specs(string $body): array
    {
        $data = [];
        $crawler = new Crawler($body);

        $spec_crawler = $this->spec_crawler($crawler);
        foreach ($spec_crawler as $node)
            // beware createSubCrawler is changed from private to public
            $this->extract_from_node($spec_crawler->createSubCrawler($node), $data);

        return $data;
    }

    protected function spec_crawler(Crawler $crawler): ?Crawler
    {
        foreach (static::$XPaths as $XPath) {
            $spec_crawler = $crawler->filterXPath($XPath)
                ->filter(".group--spec");
            if ($spec_crawler->count() > 0) return $spec_crawler;
        }

        return null;
    }

    protected function extract_from_node(Crawler $node, array& $data): void
    {
        // check header
        try{
            $header = $node->filter("h3.group__title")->text();
            if (!($header_key = static::$enumNamespace::get_key($header))) return;
            // check content (whether it's list or scalar)
            $group_content = $node->filter("div.group__content");
            if ($group_content->matches("div > ul"))
                $data[$header_key] = $this->extract_list_type($group_content);
            else
                $data[$header_key] = $this->extract_scalar_type($group_content);
        } catch (\InvalidArgumentException $e) {
            echo $e->getMessage();
        }
    }

    protected function fetchCollection(): array
    {
        try {
            $req_data = [
                RequestOptions::HEADERS => $this->collection_page_headers,
                RequestOptions::DELAY => self::$delay,
                RequestOptions::FORM_PARAMS => $this->request_form_params
            ];

            $response = $this->client->request('POST', static::$collectionUrl, $req_data);
            $body = json_decode($response->getBody()->getContents(), true)[self::RESULT][self::HTML] ?? null;

            if (!$body) return [];

            $crawler = new Crawler($body, self::$baseUrl);
            $crawler = $crawler->filter(".tr__product");
            return $crawler->each(function ($node, $i) { return static::getCollectionData($node, $i); });
        } catch (GuzzleException $e) {
            echo $e->getMessage();
            return [];
        }
    }

    abstract static protected function getCollectionData(Crawler $node, $i);
}