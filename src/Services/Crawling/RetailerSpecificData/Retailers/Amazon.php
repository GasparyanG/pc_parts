<?php


namespace App\Services\Crawling\RetailerSpecificData\Retailers;


use App\Database\Entities\Retailer;
use App\Services\Crawling\RetailerSpecificData\PersistingImplementers\AbstractPersistingImplementer;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

class Amazon extends AbstractRetailerCrawler
{
    const AMOUNT_OF_PRODUCTS_TO_WATCH = 4;
    const STARTING_PRODUCT = 2;

    public static $name = "Amazon";

    /**
     * {@inheritDoc}
     */
    protected static $baseUrl = "https://www.amazon.com/";

    // TODO: Search in name/title as well
    // css ids meant for searchTerm (i.e. whether it is under given ids or not)
    protected static $technicalDetailsId = "productDetails_techSpec_section_1";
    protected static $technicalDetailsId2 = "productDetails_techSpec_section_2";

    protected static $priceId = "priceblock_ourprice";

    protected static $headers = [
        "authority" => "www.amazon.com",
        "cache-control" => "max-age=0",
        "rtt" => "150",
        "downlink" => "10",
        "ect" => "4g",
        "upgrade-insecure-requests" => "1",
        "user-agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36",
        "accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "sec-fetch-site" => "same-origin",
        "sec-fetch-mode" => "navigate",
        "sec-fetch-user" => "?1",
        "sec-fetch-dest" => "document",
        "referer" => "https://www.amazon.com/",
        "accept-language" => "en-US,en;q=0.9,hy-AM;q=0.8,hy;q=0.7,ru-RU;q=0.6,ru;q=0.5,la;q=0.4",
        "cookie" => "ubid-main=130-1260968-9459244; session-id=135-1953471-1506126; s_fid=636B0B433E4AF2E0-31E61DB6E985CB"
            . "7C; regStatus=pre-register; x-main=\"2xgYrTsGRTw2yfttyD@8YgyPNb8o7Ya8MsYwUx?ueI68zXWYJD3n8K1fv@X2i9v9\"; "
            . "at-main=Atza|IwEBIBpplOKXPAg9e-WTiITrt2x42xMme36xf3J7lGkmMp1iTRgvl2jgsBXCSDEy8MMR0P4CWsrGdMd-PZj-3IAEs"
            . "5sm0nKxl9IaVUX7bAQLb9cogSAPp4v-6JxuMWGIO3s0vvyGzewYStACxuhlO7rZ6CDXgCZph-xjR22lD1JW8-zKjlo5pEYLkimV9dvm"
            . "fJTFkobzchNacdqUTM4gD3IMVyUpB6yCviza3YVgKBP3-9HQuyTHVOipj1G3vOjnBBQ42iyJeqQRGlTfTBCkGP40hW3qRpFxsuziQhZ"
            . "TOnGaUKyLXvun6z3EZ9AHNlHqySjiAgsMLmA3I2woIZKtROmd4ts4Kbw1EHeQqrx8QMKw1mtQZqW4ktU-Es0ZTuUOMjZyaZiEAg60a6"
            . "DV_4tv5tWA9nuS; sess-at-main=\"VIxJwx8Y08+5vLpbQNLtIJYfmigJW2KyxObE2xq4oWM=\"; sst-main=Sst1|PQG-3lN0Jo"
            . "H6qcFsJjhtfUKSCxekImIx2wUZNWfKhZtflLqyzeNGOE8TbgEVDc07g8hO6vsXytpjqwjZrwSCqNHyfAgDd8ETtZxXNnWayQktFbk3N"
            . "tdgJeMlgXfLipz_lKu2oWkWzavkh6_ZiHpEMi0xp5IV29JgRH5iMNIOkG5rddkHfDZI5OGMyhpjkK0UrEgMQSB5J3gi5lj_ieVi6HRr"
            . "8lp7iIgFy73VTdeSsCDytjAWIxc70DtxEO3k1hPpjzKLMsRueu4Yi9bEGOuJtq6Z6C8AljU_87yLKlXTEny3wYhGBzWQqtyp_Baqj86"
            . "yODSnisvEQW1P5b9Q3lPIqO6Rdg; lc-main=en_US; i18n-prefs=USD; session-id-time=2082787201l; x-wl-uid=1TfC9"
            . "pT1LDhZQij62NtmzmqYuqtA1BFnlw3ADyaK/oq9CGsde9S8Ydt7Bs31NZ8exHsCwIAAm3kIOAY/+4Fm18rEQYhhldS814oyZV6d09Ck"
            . "4tz0wOaUG6a1c3HnLvrXiKuipZ25q1MY=; aws-priv=eyJ2IjoxLCJldSI6MCwic3QiOjF9; aws-target-static-id=15816799"
            . "86399-786347; aws-target-data=%7B%22support%22%3A%221%22%7D; aws-target-visitor-id=1581679986404-76035;"
            . " s_vn=1613213345822%26vn%3D4; s_dslv=1581698600207; aws-ubid-main=683-3752545-3430382; skin=noskin; ses"
            . "sion-token=\"i3uyYJrqPxDA92WbIz115XRg6brPQ9FwbEnFUc98JKZ3y0ydPgrfXHdQ5bCNWG8BB0giVrdL3URSA87AJTkbODZtqI"
            . "hgEoAGxU7agR/FNNFU7lDg17ss0wmcPPZ8hbnpfTi5JRZ0G7UthfnygOAmPPdPfgnYV49+CNBVsoiHAkKUiigzcr5jDi37aPJXXU+rp"
            . "xf5qDEL6fmMddfOAlHB1NfMpG4dEwMYu5F4XHmf7mkPQvE4tgMNu0bJ1SHXoJYJTq91XTcFsbZaoCmAg5u/eA==\"; csm-hit=tb:M"
            . "49XTBTKGG6S75QQVJ1J+s-28E4EJMYRJJRWXWY3Y7S|1590680865116&adb:adblk_yes&t:1590680865118"
    ];

    protected static $xPaths = [
        "//*[@id=\"search\"]/div[1]/div[2]/div/span[3]/div[2]/div[%d]/div/span/div/div/div[2]/div[2]/div/div[1]/div/div/div[1]/h2/a"
    ];

    protected static $priceXPaths = [
        "//*[@id=\"search\"]/div[1]/div[2]/div/span[3]/div[2]/div[%d]/div/span/div/div/div[2]/div[2]/div/div[2]/div[1]/div/div[1]/div[2]/div/a/span/span[1]"
    ];

    protected function search(string $searchTerm): ResponseInterface
    {
        $request = new Request("GET", $this->prepareSearchUrl($searchTerm), self::$headers);
        return $this->client->send($request);
    }

    protected function desiredXpath(Crawler $crawler, array $xPaths): ?string
    {
        foreach ($xPaths as $xPath)
            for ($i = self::STARTING_PRODUCT; $i < self::AMOUNT_OF_PRODUCTS_TO_WATCH; ++$i) {
                if ($crawler->filterXPath(sprintf($xPath, $i)))
                    return $xPath;
            }
        return null;
    }

    public function crawl(string $searchTerm, int $entityId): void
    {
        $crawler = new Crawler($this->search($searchTerm)->getBody()->getContents(), self::$baseUrl);
        $xpathToSearchWith = $this->desiredXpath($crawler, self::$xPaths);
        $priceXpathToSearchWith = $this->desiredXpath($crawler, self::$priceXPaths);

        // TODO: notify (Logger Interface - PSR-3) about self::$xPaths and $searchTerm
        if (!$xpathToSearchWith) return;

        $linksToCrawl = [];
        for ($i = self::STARTING_PRODUCT; $i < self::STARTING_PRODUCT + self::$amountOfItems; ++$i) {
            try {
                if ($crawler->filterXPath(sprintf($xpathToSearchWith, $i))) {
                    $data["url"] = $crawler->filterXPath(sprintf($xpathToSearchWith, $i))->link()->getUri();
                    $data["price"] = $this->extractPrice($crawler, $priceXpathToSearchWith, $i);

                    $linksToCrawl[] = $data;
                }
            }
            catch (\InvalidArgumentException $e) {}
        }

        foreach($linksToCrawl as $link) {
            // change referer
            $headers = self::$headers;
            $headers["referer"] = $this->prepareSearchUrl($searchTerm);

            // make request
            $request = new Request("GET", $link["url"], $headers);
            $response = $this->client->send($request, [RequestOptions::DELAY => self::$delay]);

            if ($this->containsModelNumber($response, $searchTerm)) {
                $this->crawledData = [
                    AbstractPersistingImplementer::PRICE => $link[AbstractPersistingImplementer::PRICE],
                    AbstractPersistingImplementer::RETAILER_ID => $this->retailerId(),
                    AbstractPersistingImplementer::ENTITY_ID => $entityId
                ];

                // Item is already found.
                break;
            }
        }
    }

    private function extractPrice(Crawler $crawler, ?string $priceXPathToSearchWith, int $i): ?float
    {
        try {

            $price = $crawler->filterXPath(sprintf($priceXPathToSearchWith, $i))->text();
            return $this->preparePrice($price);
        }
        catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    private function preparePrice(string $priceString): ?float
    {
        // single quoted string is required, because $ sign will be treated as variable sign
        // see https://stackoverflow.com/questions/5358010/regex-failing-when-pattern-involves-dollar-sign
        $pattern = '~^\$([\d.]+)$~i';
        $matches = [];
        preg_match($pattern, $priceString, $matches);

        if (count($matches) > 0)
            return $matches[1];
        return null;
    }

    protected function prepareSearchUrl(string $searchTerm): string
    {
        return self::$baseUrl . "s?k=" . $searchTerm . "&i=electronics";
    }

    private function containsModelNumber(ResponseInterface $response, string $searchTerm): bool
    {
        $crawler = new Crawler($response->getBody()->getContents());
        $technicalDetails1 = $this->technicalDetails($crawler, self::$technicalDetailsId);
        $technicalDetails2 = $this->technicalDetails($crawler, self::$technicalDetailsId2);

        $technicalDetails = array_merge($technicalDetails1, $technicalDetails2);

        foreach($technicalDetails as $technicalDetail)
            if (trim(strtolower($technicalDetail) === strtolower($searchTerm)))
                return true;
        return false;
    }

    private function technicalDetails(Crawler $crawler, string $id): array
    {
        $newCrawler = $crawler->filter("#" . $id . " td");

        $technicalDetails = $newCrawler->each(function(Crawler $node) {
            return $node->text();
        });

        return $technicalDetails ?? [];
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
}