<?php


namespace App\Services\Crawling\RetailerSpecificData\Retailers;


use App\Database\Entities\Retailer;
use App\Services\Crawling\RetailerSpecificData\PersistingImplementers\AbstractPersistingImplementer;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Symfony\Component\DomCrawler\Crawler;

class Walmart extends AbstractRetailerCrawler
{
    static $name = "Walmart";

    /**
     * {@inheritDoc}
     */
    protected static $baseUrl = "https://www.walmart.com/";

    protected static $headers = [
        "authority" => "www.walmart.com",
        "cache-control" => "max-age=0",
        "upgrade-insecure-requests" => "1",
        "user-agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36",
        "accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "sec-fetch-site" => "same-origin",
        "sec-fetch-mode" => "navigate",
        "sec-fetch-user" => "?1",
        "sec-fetch-dest" => "document",
        "referer" => "https://www.walmart.com/",
        "accept-language" => "en-US,en;q=0.9,hy-AM;q=0.8,hy;q=0.7,ru-RU;q=0.6,ru;q=0.5,la;q=0.4",
        "cookie" => "DL=94066%2C%2C%2Cip%2C94066%2C%2C; vtc=eajcIt5I5lINTSTbzdS7qM; AID=wmlspartner%3D0%3Areflectorid%3D0000000000000000000000%3Alastupd%3D1561622478503; TS013ed49a=01538efd7c20fcf3a21943a731e793d0f1fd563990423a4f34aab4ede001668ca7c26154989a61b65bd66c44fad526f152d7d68aae; cart-item-count=0; TS01b0be75=01538efd7c6747b9735f634cb34b17c23a50ddcc83c13dabe61eaba3f887d721deef2c7f04308f1834fc9b9b96a92fb1fbf86622b6; TS01e3f36f=01c5a4e2f9bff116ad96503b0ca72e6cc0ea3f2eef384ab4d9a174aaca0360074b19f26f1e71aa5e31be41594f6fedf8256b4407f2; TS018dc926=01c5a4e2f9bff116ad96503b0ca72e6cc0ea3f2eef384ab4d9a174aaca0360074b19f26f1e71aa5e31be41594f6fedf8256b4407f2; com.wm.reflector=\"reflectorid:0000000000000000000000@lastupd:1590682191033@firstcreate:1590682184353\"; adblocked=true; akavpau_p8=1590682802~id=ece52f633a7968d305d5320a2e903778; TS011baee6=0130aff23260c9a73f6cb0b6634d2d30890a3d8907f305e902e29854934b43cace9dec2fdd5fa4755550da48f91402cffee98843a8; akavpau_p0=1590682806~id=56d404a37de6490d0d1639a0955c1639",
    ];

    public function crawl(string $searchTerm, int $entityId): void
    {
        $request = new Request('GET', $this->prepareSearchUrl($searchTerm), self::$headers);
        $response = $this->client->send($request);

        $crawler = new Crawler($response->getBody()->getContents());
        $data_in_json = $crawler->filter("#searchContent")->text();
        $assocArray = json_decode($data_in_json, true);

        foreach ($this->getData($this->extractItems($assocArray)) as $product) {
            $request = new Request("GET", $this->fullUrl($product['url']), self::$headers);
            $response = $this->client->send($request, [RequestOptions::DELAY => self::$delay]);

            $crawler = new Crawler($response->getBody()->getContents());

            try {
                // TODO: make more validated
                $modelNumber = $crawler->filter(".prod-productsecondaryinformation > div")->eq(1)->text();

//                $imageUrls = $crawler->filter(".prod-alt-image-carousel-image--left");

//                echo "\n\n\n" . $imageUrls->count() . "\n\n\n";

                if ($this->processModelNumber($modelNumber) === $searchTerm) {
                    $this->crawledData = [
                        AbstractPersistingImplementer::PRICE => $product[AbstractPersistingImplementer::PRICE],
                        AbstractPersistingImplementer::URL => $this->prepareLink($product),
                        AbstractPersistingImplementer::RETAILER_ID => $this->retailerId(),
                        AbstractPersistingImplementer::ENTITY_ID => $entityId
                    ];

                    // Item is already found.
                    break;
                }
            } catch (\InvalidArgumentException $e) {
                echo $e->getMessage() . "\n";
            }
        }
    }


    protected function processModelNumber(string $modelNumberString): ?string
    {
        $pattern = "~^Model:\s*(.*)$~i";
        $matches = [];
        preg_match($pattern, $modelNumberString, $matches);

        if (count($matches) > 0)
            return trim($matches[1]);
        return null;
    }

    protected function prepareSearchUrl(string $searchTerm): string
    {
        return self::$baseUrl . "search/?query=" . $searchTerm;
    }

    protected function getData(array $items): array
    {
        $dataToReturn = [];
        for ($i=0; $i<self::$amountOfItems; ++$i) {
            if (isset($items[$i])){
                $item = $items[$i];
                $itemData = [];
                // TODO: declare this keys to constants
                $itemData["url"] = $item["productPageUrl"];
                $itemData["price"] = $item["primaryOffer"]["offerPrice"] ?? null;

                $dataToReturn[] = $itemData;
            } else break;
        }

        return $dataToReturn;
    }

    protected function fullUrl(string $relative): string
    {
        return self::$baseUrl . ltrim($relative, '/');
    }

    protected function retailerId(): int
    {
        $retailer = $this->em->getRepository(Retailer::class)->findOneBy(
            [
                Retailer::NAME => static::$name
            ]
        );

        return $retailer->getId();
    }

    protected function extractItems(array $assocArray): array
    {
        return $assocArray["searchContent"]["preso"]["items"];
    }

    protected function prepareLink($product): ?string
    {
        $url = $product[AbstractPersistingImplementer::URL] ?? null;
        if (!$url) return null;

        // add base url
        $link = $url;
        if (strpos($url, "https://") === false)
            $link = self::$baseUrl . $url;

        return $link;
    }
}