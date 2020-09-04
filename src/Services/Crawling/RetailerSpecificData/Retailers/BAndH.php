<?php


namespace App\Services\Crawling\RetailerSpecificData\Retailers;


use App\Database\Entities\Retailer;
use App\Services\Crawling\RetailerSpecificData\PersistingImplementers\AbstractPersistingImplementer;
use App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping\ImageAbstractScraper;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\DomCrawler\Crawler;

class BAndH extends AbstractRetailerCrawler
{
    static $name = "B&H";

    /**
     * {@inheritDoc}
     */
    protected static $baseUrl = "https://www.bhphotovideo.com/";

    protected static $headers = [
        "authority" => "www.bhphotovideo.com",
        "cache-control" => "max-age=0",
        "upgrade-insecure-requests" => "1",
        "user-agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36",
        "accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "sec-fetch-site" => "same-origin",
        "sec-fetch-mode" => "navigate",
        "sec-fetch-user" => "?1",
        "sec-fetch-dest" => "document",
        "referer" => "https://www.bhphotovideo.com/",
        "accept-language" => "en-US,en;q=0.9,hy-AM;q=0.8,hy;q=0.7,ru-RU;q=0.6,ru;q=0.5,la;q=0.4",
        "cookie" => "cookieID=198030939571588167250188; sessionKey=58254980-3efe-45bb-aab8-fef8559dce93; aperture-be-commit-id=n/a; mapp=0; dcid=1588167250169-60335387; aperture-be-commit-id=n/a; __cfduid=dd76904e73c61daa92aef91fdd1221b381592822722; uui=800.606.6969|; locale=en; cartId=19069006999; D_ZID=A19BB9EA-2305-3698-80B8-D385F05AA574; D_ZUID=500076F3-0FF2-321A-85FB-EB98F4D922C0; D_HID=12862DD3-3E50-3262-BB64-F82DC1C2A723; D_SID=37.252.80.95:IcECjwhukDUzmEXyy0lEPHVPKCN3448KwnOXkAdYdqs; ab_nglp=A; SSID_C=CAAy-R0AAAAAAABSgqleTxIBI1KCqV4FAAAAAAAAAAAAZ4D0XgANyA; SSSC_C=333.G6821126399915528783.5|0.0; dpi=cat=2,cur=USD,app=D,lang=E,view=L,lgdin=N,cache=release-WEB-20200624v10-BHJ-DVB24146-17; JSESSIONID=HQHrFZSS2mXeDWSzdMgscf0XEUPdCZFX\u0021930898451; pvid=1593081959551-76939448; build=20200624v10-20200624v10; TS0188dba5=01ec39615f2eebac59dddc76df8af1bb1d348ea18ce6f6ce5a8f1ccbe54c1b4856d9477864f4343a0694c37e6488b15d474648d522d5722d26074f486abd5c1cbcf342b5836927ea09c8b56b9b90d8f98818bf302da0cfcf5770536fc773ed8249ad4ce619; lpi=cat=2,cur=USD,app=D,lang=E,view=L,lgdin=N,cache=release-WEB-20200624v10-BHJ-DVB24146-17,ipp=24,view=L,sort=BS,priv=N,state=; my_cookie=\u0021qSDSgxoy5xhTlG+eJCrTZVkP1XPzVEAgPfg+t88rITDQwTl5xD/PgqJp17lygQsEcxLn/ujQ4SnflVp2s1hgkz+m2poUxwh4KoCeaZJZ/Hy1of9w3WbDmg4Vzhi88itMbhepWJKBSSWmz6T785cJJDeL1PN7HUNUqyG3MyPvbfM7tv3epSQAOcQYPokUGYIjE2sWFBhA6Q==; TS01d628c4=01ec39615f5b905e31aa7d14d749fa8b9d396d4285bf63fe9284296152ce56b74fdd247857a9bbb0721fb564842de039191b967c5b5073b7d0d765aaf524950133b52cb180b9bce60873aa5792fde63df23d18783485545c3e244bb290de6e78c267679020db63dab60e7bb9378a92701200383828064f2de7d48a404358e66853fb726fa1a59773b6edd3f8a195f02c165e41035ee14058fadecf4cf1f06d4b41a12f27508bae10137a16a2cd33e78cea32dde0f04961e330666a11533b0db4f2bc830ff2a4e891d2f3d1d572503cfa556700b4471015d9396fdb533397f350a8559632d5; utkn=d91d05edb3f8a3486cc58eac2cfbbf2c; __cf_bm=7207c77aec051f8e0bdecf51f26fc498ac015ded-1593081959-1800-ASq3Z+ZVVm7Ig6hHtVZP2RD+inKm8nN6+IRbOTNosOB7kbqWNcJHlSxxlt08DZ+XMb04nG5v1hnW8tCWI9abIBQ=; __cfruid=00d90db705157756e993d5f1cb7efbda7214c9fe-1593081959; TopBarCart=0|0; TS0188dba5_77=080f850069ab2800ea36a9b0437d1798043f9ced9377065dc16448ed24d65f5148db27fa3b4e85bb9e2966322476847e08df0df7b082400005f736511b267bf6a1db462844c534a92c7d68c2315d1609ede96434897cd116f12e618fd15f3b4ab49c502c08a95d48b9bd6163e9fa10dec7144e83905153fe; SSRT_C=DYH0XgQBAA; SSPV_C=FTAAAAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAA; D_IID=2EF83010-E68B-3D47-B49D-DAB709C3B5B0; D_UID=15869FF9-037B-313F-94BB-D84B64227B82; forterToken=bca3650f7dd8479e93c9cb87a66bf752_1593082221446_1290_UAL9_6; TS01e1f1fd=01ec39615fe968b7eeb7347ed921eed19226b1a0c9bf63fe9284296152ce56b74fdd24785765d4fea4eee4ee2b11513d20e4342e1266f376a7bdf9f482ce7af84c9758d647a1bf6a726d263fb4a228a7abc010bd63ed40b2a53275c40aab95607510f298b82d1fd098849a39525ccb9554aa352dae5b8491c8b5bb3f0a170996b26c28ae362fa04dc70353a4de28a333281f13710e; app_cookie=1593082129",
    ];

    /**
     * part number is under /div[1]
     * @var string
     */
    protected static $partNumberRelativeXPath = "/div[1]";

    /**
     * link is under /h3/a
     * @var string
     */
    protected static $linkRelativeXPath = "/h3/a";

    protected static $xPaths = [
        "//*[@id=\"listingRootSection\"]/div/div[3]/section/div[1]/div[%d]/div/div[2]" =>
            "//*[@id=\"listingRootSection\"]/div/div[3]/section/div[1]/div[%d]/div/div[3]/div[1]/div/div[1]/span"
    ];

    protected function correctXPath(Crawler $crawler): array
    {
        $arrayTOReturn = [null, null, null];
        for ($i = 1; $i< 1 + self::$amountOfItems; ++$i)
            foreach (self::$xPaths as $partNumberXpath => $priceXpath) {
                $crawler = $crawler->filterXPath(sprintf($partNumberXpath, $i));
                if ($crawler->count()) {
                    return [$partNumberXpath, $priceXpath, $i];
                }
            }
        return $arrayTOReturn;
    }

    public function crawl(string $searchTerm, int $entityId, ?ImageAbstractScraper $imageAbstractScraper): void
    {
        $request = new Request('GET', $this->prepareSearchUrl($searchTerm), self::$headers);
        $response = $this->client->send($request);

        $crawler = new Crawler($response->getBody()->getContents(), self::$baseUrl);
        [$numberXpath, $priceXpath, $numberToStart] = $this->correctXpath($crawler);

        if (!$numberXpath || !$priceXpath || !$numberToStart) return;

        for ($i = $numberToStart; $i < $numberToStart + self::$amountOfItems; ++$i) {
            // part number extraction
            $partNumber = $this->extractPartNumber($crawler, $numberXpath, $i);
            $link = $this->extractLink($crawler, $numberXpath, $i);

            if ($partNumber != $searchTerm) continue;
            // price extraction
            $price = $this->extractPrice($crawler, $priceXpath, $i);
            if (!$price) continue;

            $this->crawledData = [
                AbstractPersistingImplementer::PRICE => $price,
                AbstractPersistingImplementer::URL => $link,
                AbstractPersistingImplementer::RETAILER_ID => $this->retailerId(),
                AbstractPersistingImplementer::ENTITY_ID => $entityId
            ];

            // Download and persist images from provided product page
            $this->pullImages($entityId, $imageAbstractScraper);

            // Item is already found.
            break;
        }

    }

    protected function prepareSearchUrl(string $searchTerm): string
    {
        return self::$baseUrl . "c/search?Ntt=" . $searchTerm;
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

    private function extractPartNumber(Crawler $crawler, string $numberXpath, int $i): ?string
    {
        $crawler = $crawler->filterXPath(sprintf($numberXpath . self::$partNumberRelativeXPath, $i));
        if (!$crawler->count()) return null;

        try {
            return $this->preparePartNumber($crawler->text());
        } catch (\InvalidArgumentException $e) {
            // TODO: define in logger (psr-3)
            echo $e->getMessage() . " In extractPartNumber method\n";
            echo "number XPath: " . $numberXpath . "\n";
            echo "iteration number: " . $i . "\n";

            return null;
        }
    }

    private function extractLink(Crawler $crawler, string $numberXpath, int $i): ?string
    {
        $crawler = $crawler->filterXPath(sprintf($numberXpath . self::$linkRelativeXPath, $i));
        if (!$crawler->count()) return null;

        try {
            return $crawler->link()->getUri();
        } catch (\InvalidArgumentException $e) {
            // TODO: define in logger (psr-3)
            echo $e->getMessage() . " In extractPartNumber method\n";
            echo "number XPath: " . $numberXpath . "\n";
            echo "iteration number: " . $i . "\n";

            return null;
        }
    }

    private function preparePartNumber(string $partNumberString): ?string
    {
        // B&H # AMDR73700X MFR # 100-100000071BOX
        $pattern = "~.+MFR\s*#\s*(.+)~i";
        $matches = [];
        preg_match($pattern, $partNumberString, $matches);

        if (count($matches) > 0) return trim($matches[1]);
        return null;
    }

    private function extractPrice(Crawler $crawler, string $priceXpath, int $i): ?float
    {
        $crawler = $crawler->filterXPath(sprintf($priceXpath, $i));

        try {
            $integerPart = $this->preparePrice($crawler->filter("span")->text());

            if (!$integerPart) return null;

            // floating-point part
            $crawler = $crawler->filter("sup");
            return $this->addFloatingPoint($integerPart, $crawler->text());
        } catch (\InvalidArgumentException $e) {
            // TODO: define in logger (psr-3)
            echo $e->getMessage() . " In extractPrice method\n";
            echo "number XPath: " . $priceXpath . "\n";
            echo "iteration number: " . $i . "\n";

            return null;
        }
    }

    protected function addFloatingPoint(string $integerPart, ?string $floatingPointPart): ?float
    {
        $integerPart = str_replace('.', '', $integerPart);
        $length = strlen($integerPart);
        $lengthFloat = strlen($floatingPointPart);

        $differ = $length - $lengthFloat;
        if ($differ < 0) return null;

        return substr($integerPart, 0, $differ) . "." . $floatingPointPart;
    }

    protected static function preparePrice(string $priceString): ?float
    {
        $pattern = '~\$([\d.,]+)~i';
        $matches = [];
        preg_match($pattern, $priceString, $matches);

        if (count($matches) > 0)
            return self::tofloat($matches[1]);
        return null;
    }


    // IMAGE PULLING
    protected function pullImages(int $entityId, ?ImageAbstractScraper $imageAbstractScraper): void
    {
        // Don't proceed to get images, because entity already have them
        if (!$imageAbstractScraper->imageIsRequired($entityId)) return;

        // Extract images urls from product page
        $this->extractImageUrls($this->crawledData);

        // Download images and persist
        $this->downloadAndPersist($this->crawledData, $entityId, $imageAbstractScraper);
    }

    protected function extractImageUrls(array& $crawledData): void
    {
        // Don't proceed if there is no link to process
        if (!$crawledData[AbstractPersistingImplementer::URL]) return;

        // send request
        $request = new Request("GET", $crawledData[AbstractPersistingImplementer::URL], self::$headers);
        $response = $this->client->send($request);

        // prepare crawler
        $crawler = new Crawler($response->getBody()->getContents(), self::$baseUrl);
        $thumbnails = $crawler->filter("[data-selenium=thumbnail] > img");

        // extract images
        $images = $thumbnails->each(function(Crawler $crawler) {
            return $crawler->extract(["src"])[0];
        });

        // update images
        $crawledData[AbstractPersistingImplementer::IMAGES] = $images;
    }

    protected function downloadAndPersist(array $crawledData, int $id, ?ImageAbstractScraper $imageAbstractScraper): void
    {
        if (!isset($crawledData[AbstractPersistingImplementer::IMAGES]) || !$imageAbstractScraper) return;

        // Image scraper will deal with crawled data persistence as well.
        $imageAbstractScraper->downloadWithUrlsAndPersist($this->processImages($crawledData[AbstractPersistingImplementer::IMAGES]), $id);
    }

    protected function processImages(array $urls)
    {
        $patterns = ["~smallimages~", "~thumbnails~"];              // string to replace
        $replacements = "images500x500";                            // string to replace with

        for ($i = 0; $i < count($urls); ++$i)
            $urls[$i] = preg_replace($patterns, $replacements, $urls[$i]);

        return $urls;
    }
}