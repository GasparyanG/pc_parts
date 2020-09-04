<?php


namespace App\Services\Crawling\RetailerSpecificData\Retailers;


use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Symfony\Component\DomCrawler\Crawler;

class BestBuy extends AbstractRetailerCrawler
{
    /**
     * {@inheritDoc}
     */
    protected static $baseUrl = "https://www.bestbuy.com/";

    protected static $headers = [
        "authority" => "www.bestbuy.com",
        "cache-control" => "max-age=0",
        "upgrade-insecure-requests" => "1",
        "user-agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36",
        "accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "sec-fetch-site" => "same-origin",
        "sec-fetch-mode" => "navigate",
        "sec-fetch-user" => "?1",
        "sec-fetch-dest" => "document",
        "referer" => "https://www.bestbuy.com/",
        "accept-language" => "en-US,en;q=0.9,hy-AM;q=0.8,hy;q=0.7,ru-RU;q=0.6,ru;q=0.5,la;q=0.4",
        "cookie" => "tfs_upg=true; UID=ef2fe269-a659-4a3e-abfd-25cadd30408c; oid=579479457; SID=6e964028-07b9-4fda-9352-db04d507357a; CTT=b5d78e4d27c9ad7cbadae6fd2044b8bf; AMCVS_F6301253512D2BDB0A490D45%40AdobeOrg=1; s_cc=true; tfs_upg=true; 52245=; optimizelyEndUserId=oeu1588163753670r0.9174514666187965; COM_TEST_FIX=2020-04-29T12%3A35%3A53.951Z; locStoreId=463; locDestZip=04785; pst2=463; sc-location-v2=%7B%22meta%22%3A%7B%22CreatedAt%22%3A%222020-04-29T12%3A35%3A59.091Z%22%2C%22ModifiedAt%22%3A%222020-04-29T12%3A35%3A59.524Z%22%2C%22ExpiresAt%22%3A%222021-04-29T12%3A35%3A59.524Z%22%7D%2C%22value%22%3A%22%7B%5C%22physical%5C%22%3A%7B%5C%22zipCode%5C%22%3A%5C%2204785%5C%22%2C%5C%22source%5C%22%3A%5C%22A%5C%22%2C%5C%22captureTime%5C%22%3A%5C%222020-04-29T12%3A35%3A59.090Z%5C%22%7D%2C%5C%22store%5C%22%3A%7B%5C%22zipCode%5C%22%3A%5C%2204401%5C%22%2C%5C%22storeId%5C%22%3A463%2C%5C%22storeHydratedCaptureTime%5C%22%3A%5C%222020-04-29T12%3A35%3A59.523Z%5C%22%7D%2C%5C%22destination%5C%22%3A%7B%5C%22zipCode%5C%22%3A%5C%2204785%5C%22%7D%7D%22%7D; _cs_c=1; _abck=018C8F0C0FA123624D81A39CF1E8336F~0~YAAQnFNlX2uChsdyAQAAlHKd2wQe94ILKJgfoERPxnqBb3gqzhS65cLui6hze8jNfWHSxmiwRGeWMDk9uHy+1V6jDV+QI6Io2rBTCe1xHRWzHFnNZrGax77IewEW30uKCQykOifsm+4yfWs+x7V7FBF6ChVQKb0OmNns0xr6W52m3jaIHqjISi4ALp9E6cCz/XKR7gY2jAYmfHMMIru0B3TQws7+Qc503pEy1twuyX1G5aG+gbFX9kyoc0q/KuVCiWvG4GbVhi4z0rFWaGkTXIlf5uTOyCKwhMPZPlaRnpib8grMqEe+kNbzCCyY7LWPzZQvEk6ga+E=~-1~-1~-1; bby_rdp=l; bm_sz=6632353FF8C856FF2DF9FE3101CC96FC~YAAQj08VAlHOQq1yAQAA4quX5gjyEZIiDqwQO2JS9d75acgOr+Mz7LYHUiUdH3hpjCM2aTJuHmnXzVgX6UAY2Rae/bwGNCawdt6nYigRnhQ47wSuwE7DkyC4pLZfLEjsLbNK9L2T5U4/mCq1k+fXxfnk1CkjgihakWXvh0M8zlsRO9/5vIG6nqEs2vw7vMevuA==; bby_cbc_lb=p-browse-e; vt=9908ad6a-b621-11ea-9714-063668baa05e; intl_splash=false; ltc=%20; globalUserTransition=cba; c6db37d7c8add47f1af93cf219c2c682=b499a21d8b0e7ebb0cbc6a5f30a0838a; basketTimestamp=1593006606638; bby_prc_lb=p-prc-w; bby_suggest_lb=p-suggest-e; lastSearchTerm=GA-B450-AORUS-M; listFacets=undefined; bby_ispu_lb=p-ispu-e; s_sq=%5B%5BB%5D%5D; _cs_id=889c1181-0041-af6f-bd19-fc4f51d947a4.1588163761.6.1593006817.1593006713.1.1622327761076.Lax.0; _cs_s=5.1; c2=Search%20Results; AMCV_F6301253512D2BDB0A490D45%40AdobeOrg=1585540135%7CMCMID%7C16101226914382685659113348654371420667%7CMCAID%7CNONE%7CMCOPTOUT-1593014017s%7CNONE%7CvVersion%7C4.4.0"
    ];

    public function crawl(string $searchTerm, int $entityId, ?ImageAbstractScraper $imageAbstractScraper): void
    {

        $request = new Request("GET", $this->prepareSearchUrl($searchTerm), self::$headers);
        $response = $this->client->send($request, [RequestOptions::DELAY => self::$delay]);

        var_dump($response->getBody()->getContents());

        // filtering of skuItems
        // filtering of skuItems
        $crawler = new Crawler($response->getBody()->getContents());
        $skuItems = $crawler->filter(".sku-item-list .sku-item");
        echo count($skuItems) . "\n";

        $priceAndModelNumber = $skuItems->each(function(Crawler $node) {
            $dataToReturn = [];
            $dataToReturn["model_number"] = $node->filter(".sku-item .sku-value")->text();

            // price extraction
            // priceView-hero-price
            $dataToReturn["price"] = $node->filter(".sku-item .priceView-hero-price > span")->first()->text();

            return $dataToReturn;
        });

        var_dump($priceAndModelNumber);
    }

    protected function prepareSearchUrl(string $searchTerm): string
    {
        return self::$baseUrl . "site/searchpage.jsp?st=" . $searchTerm;
    }
}