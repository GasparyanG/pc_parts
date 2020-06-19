<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartScraping;


use App\Services\Crawling\Specifications\PCPartPicker\Parts\Cooler;
use App\Services\Crawling\Specifications\PCPartPicker\Parts\PcCase;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Symfony\Component\DomCrawler\Crawler;

class CaseScraper extends AbstractScraping
{
    static $collectionUrl = "https://pcpartpicker.com/products/case/fetch/";
    static $enumNamespace = "App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum\CaseExtractionEnum";

    /**
     * {@inheritDoc}
     */
    static $XPaths = [
        "//*[@id=\"product-page\"]/section/div[2]/section[2]/div/div[1]/div[2]",
        "//*[@id=\"product-page\"]/section/div[2]/section[2]/div/div[1]/div[3]",
        "//*[@id=\"product-page\"]/section/div[2]/section/div/div[1]/div[3]",
        "//*[@id=\"product-page\"]/section/div[2]/section/div/div[1]/div[4]"
    ];

    /**
     * @var array
     */
    protected $collection_page_headers = [
        "authority" => "pcpartpicker.com",
        "user-agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36",
        "accept" => "application/json, text/javascript, */*; q=0.01",
        "content-type" => "application/x-www-form-urlencoded; charset=UTF-8",
        "x-csrftoken" => "DQkGqCEtILSOWlANbIJGSoPj7U5kFKoe6IpOFbuvO4b18njVMnkR48E0AZym5V4w",
        "x-requested-with" => "XMLHttpRequest",
        "sec-fetch-site" => "same-origin",
        "sec-fetch-mode" => "cors",
        "sec-fetch-dest" => "empty",
        "referer" => "https://pcpartpicker.com/products/case/",
        "origin" => "https://pcpartpicker.com",
        "accept-language" => "en-US,en;q=0.9,hy-AM;q=0.8,hy;q=0.7,ru-RU;q=0.6,ru;q=0.5,la;q=0.4",
        "cookie" => "xcsrftoken=DQkGqCEtILSOWlANbIJGSoPj7U5kFKoe6IpOFbuvO4b18njVMnkR48E0AZym5V4w; "
            . "xgdpr-consent=allow; "
            . "theme=light-mode; xsessionid=lqcvep65fzh8eji6nc5cpr3e9t4wzp12; "
            . "__cfduid=d66736e21d329af7bbccdc3241a8b58961590753547"
    ];

    /**
     * Meant for collection retrieval.
     *
     * @var array
     */
    protected $request_form_params = [
        "xslug" => "",
        "location" => "",
        "token" => "f316129bd76ccb70e03bcabf899ea6e8%3A4rOufzAiN7HPPZyCQlmvxThx7T1SFbEojA5sYgdvGJBKmDayelKhHpRmR5954JOFj%2FIH1GF%2BygYHxZ%2F8qXHXtw%3D%3D",
        "search" => "",
        "qid" => 1,
        "scr" => 1,
        "scr_cw" => 1903,
        "scr_vh" => 357,
        "scr_dw" => 1920,
        "scr_dh" => 1080,
        "scr_daw" => 1920,
        "scr_dah" => 1040,
        "scr_ddw" => 1903,
        "scr_ddh" => 4538,
        "ms" => 1592560549580
    ];

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
        "referer"  => "https://pcpartpicker.com/products/case/",
        "accept-language" => "en-US,en;q=0.9,hy-AM;q=0.8,hy;q=0.7,ru-RU;q=0.6,ru;q=0.5,la;q=0.4",
        "cookie" => "xcsrftoken=DQkGqCEtILSOWlANbIJGSoPj7U5kFKoe6IpOFbuvO4b18njVMnkR48E0AZym5V4w; "
            . "xgdpr-consent=allow; theme=light-mode; "
            . "xsessionid=lqcvep65fzh8eji6nc5cpr3e9t4wzp12; "
            . "__cfduid=d66736e21d329af7bbccdc3241a8b58961590753547"
    ];

    public function crawl(): void
    {
        try {
            $collection = $this->fetchCollection();
            for ($i=0; $i<count($collection); ++$i) {
                $part = $collection[$i];

                echo $i . " is starting... \n";

                if (!isset($part[Cooler::URL]) && !isset($part[Cooler::NAME])
                    && !filter_var($part["url"], FILTER_VALIDATE_URL)) continue;

                // start scraping page
                $request = new Request("GET", $part["url"], $this->single_resource_headers);
                $response = $this->client->send($request, [RequestOptions::DELAY => self::$delay]);
                $body = $response->getBody()->getContents();

                // scraping
                $data_from_spec_page = $this->extract_specs($body);
                $data_from_spec_page[Cooler::NAME] = $part[Cooler::NAME];
                $data_from_spec_page[Cooler::URL] = $part[Cooler::URL];

                $case = new PcCase($data_from_spec_page);
                file_put_contents(__DIR__ . "/test_case.txt", print_r($case->toArray(), true), FILE_APPEND);
//
//                // persisting
//                $coolerPersistingImplementer = new MemoryPersistingImplementation($memory);
//                $coolerPersistingImplementer->insert();

                echo $i . " is finished already!\n";
            }
        } catch (GuzzleException $e) {
            echo $e->getMessage();
            return;
        } catch (\InvalidArgumentException $e) {
            echo $e->getMessage();
        }
    }

    static protected function getCollectionData(Crawler $node, $i)
    {
        $data = [];
        $data[Cooler::NAME] = $node->filter(".td__name > a > .td__nameWrapper > p")->text();
        $data[Cooler::URL] = $node->filter(".td__name > a")->link()->getUri();

        return $data;
    }
}