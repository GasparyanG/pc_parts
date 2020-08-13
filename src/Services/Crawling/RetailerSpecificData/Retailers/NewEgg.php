<?php


namespace App\Services\Crawling\RetailerSpecificData\Retailers;


use App\Database\Entities\Retailer;
use App\Services\Crawling\RetailerSpecificData\PersistingImplementers\AbstractPersistingImplementer;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\DomCrawler\Crawler;

class NewEgg extends AbstractRetailerCrawler
{
    static $name = "NewEgg";

    /**
     * {@inheritDoc}
     */
    protected static $baseUrl = "https://www.newegg.com/";

    protected static $headers = [
        "authority" => "www.newegg.com",
        "cache-control" => "max-age=0",
        "upgrade-insecure-requests" => "1",
        "user-agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36",
        "accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "sec-fetch-site" => "same-origin",
        "sec-fetch-mode" => "navigate",
        "sec-fetch-user" => "?1",
        "sec-fetch-dest" => "document",
        "referer" => "https://www.newegg.com/",
        "accept-language" => "en-US,en;q=0.9,hy-AM;q=0.8,hy;q=0.7,ru-RU;q=0.6,ru;q=0.5,la;q=0.4",
        "cookie" => "ComponentsPV=1; TOTALPRD=1; NV%5FW57=USA; NV%5FW62=en; usprivacy=1---; OneTrustWPCCPAGoogleOptOut=false; AMCVS_1E15776A524450BC0A490D44%40AdobeOrg=1; mt.v=2.1803607259.1588163009792; _ga=GA1.2.1307493265.1588163010; s_fid=6B149D6276A5A029-08A9EFC1A23F69A4; s_cc=true; _gid=GA1.2.1485331147.1590662776; AMCV_1E15776A524450BC0A490D44%40AdobeOrg=1687686476%7CMCIDTS%7C18411%7CMCMID%7C91777558861984519840858638416125722514%7CMCAID%7CNONE%7CMCOPTOUT-1590669976s%7CNONE%7CvVersion%7C3.0.0; INGRESSCOOKIE=1590662729.524.10726.12899; NV%5FPRDLIST=#5%7B%22Sites%22%3A%7B%22USA%22%3A%7B%22Values%22%3A%7B%22w32%22%3A%22g%22%2C%22wg%22%3A%2236%22%2C%22wl%22%3A%22BESTMATCH%22%2C%22wn%22%3A%22Y%22%7D%2C%22Exp%22%3A%221677063906%22%7D%7D%7D; NV%5FNEWGOOGLE%5FANALYTICS=#5%7B%22Sites%22%3A%7B%22USA%22%3A%7B%22Values%22%3A%7B%22w14%22%3A%221%22%7D%2C%22Exp%22%3A%221593255912%22%7D%7D%7D; s_sess=%20s_evar36%3Dnatural%257Cgoogle%3B%20s_eVar37%3Dnatural%257Cgoogle%3B%20s_campaign%3Dnatural%257Cgoogle%3B%20s_cpc%3D0%3B%20s_stv%3Dcpu%3B%20s_evar17%3Dpage%2520viewed%253A1%252Cseries%253Aintel%2520core%2520i7%252Csort%2520by%253Abestmatch%252Cview%2520count%253A36%3B%20c_m%3Dundefinedwww.google.comNatural%2520Search%3B%20s_ev3%3Dnon-internal%2520campaign%3B; NVTC=248326808.0001.srkqrg23a.1588162957.1590662699.1590666783.5; NID=341j2Q346I6I5z345z0cdbb57812b96ed16a15b718112dc5d22; NSC_mc-xxx.ofxfhh.dpn-vsmibti=475ca3ddf024fd20fe3cc0ba5f1178f5e1095f1f5c18df191f404231042b4088ce55117b; NV%5FCONFIGURATION=#5%7B%22Sites%22%3A%7B%22USA%22%3A%7B%22Values%22%3A%7B%22wd%22%3A%221%22%2C%22w58%22%3A%22USD%22%2C%22w57%22%3A%22USA%22%2C%22w39%22%3A%226676%22%2C%22w61%22%3A%221619699009000%22%7D%2C%22Exp%22%3A%221677066861%22%7D%7D%7D; NV%5FDVINFO=#5%7B%22Sites%22%3A%7B%22USA%22%3A%7B%22Values%22%3A%7B%22w19%22%3A%22Y%22%7D%2C%22Exp%22%3A%221590753261%22%7D%7D%7D; OptanonConsent=isIABGlobal=false&datestamp=Thu+May+28+2020+15%3A54%3A24+GMT%2B0400+(Armenia+Standard+Time)&version=6.0.0&landingPath=NotLandingPage&groups=C0001%3A1%2CC0003%3A1%2CC0002%3A1%2CC0004%3A1&hosts=&consentId=b05bc987-3cb3-49fc-97e5-b956355fbc17&interactionCount=0&AwaitingReconsent=false&geolocation=AM%3BER&legInt=; OptanonAlertBoxClosed=2020-05-28T11:54:24.026Z; _gat=1; s_sq=%5B%5BB%5D%5D; NV_NVTCTIMESTAMP=1590666793; mt.visits=%7B%22lastVisit%22:1590666868369,%22visits%22:%5B2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,1%5D%7D; mt.mbsh=%7B%22fs%22:1590666869758,%22sf%22:1,%22lf%22:1590666869759%7D; s_pers=%20s_ns_persist%3DNatural%257CGoogle%7C1590755009895%3B%20s_ev19%3D%255B%255B%2527natural%25257Cgoogle%2527%252C%25271588163009921%2527%255D%255D%7C1745929409921%3B%20productnum%3D29%7C1593255914027%3B%20s_vs%3D1%7C1590668669849%3B%20gpv_pv%3Dhome%2520%253E%2520components%2520%253E%2520cpus%2520%2F%2520processors%2520%253E%2520processors%2520-%2520desktops%2520%253E%2520amd%2520%253E%2520item%2523%253An82e16819113571%253Aproduct%7C1590668669865%3B%20s_nr%3D1590666869873-Repeat%7C1622202869873%3B%20gpvch%3Dbrowsing%7C1590668669880%3B; mt.pevt=mr%3Dt1576758332%26mi%3D'2.1803607259.1588163009792'%26u%3D'https://www.newegg.com/amd-ryzen-3-3200g/p/N82E16819113571%253FItem%253DN82E16819113571%2526cm_sp%253Dhomepage_dailydeals-_-p1_19-113-571-_-05282020%2526quicklink%253Dtrue'%26e%3D\u0021(xi)%26ii%3D\u0021('4,2,30307,,,,1590666794,0,1590666869','4,2,30303,,,,1590666794,1,1590666869')%26eoq%3D\u0021t",
    ];

    public function crawl(string $searchTerm, int $entityId): void
    {
        $request = new Request('GET', $this->prepareSearchUrl($searchTerm), self::$headers);
        $response = $this->client->send($request);

        $crawler = new Crawler($response->getBody()->getContents(), self::$baseUrl);
        $crawler = $crawler->filter(".item-container");

        $products = $crawler->each(function(Crawler $node) {
            $dataToReturn = [];
            $dataToReturn["price"] = self::extractPrice($node);
            $dataToReturn["model_number"] = self::extractModelNumber($node);
            $dataToReturn["url"] = self::extractLink($node);

            return $dataToReturn;
        });

        foreach($products as $product)
            if ($product["model_number"] == $searchTerm) {
                $this->crawledData = [
                    AbstractPersistingImplementer::PRICE => $product[AbstractPersistingImplementer::PRICE],
                    AbstractPersistingImplementer::URL => $product[AbstractPersistingImplementer::URL],
                    AbstractPersistingImplementer::RETAILER_ID => $this->retailerId(),
                    AbstractPersistingImplementer::ENTITY_ID => $entityId
                ];

                // Item is already found.
                break;
            }
    }

    protected static function extractPrice(Crawler $node): ?float
    {
        try {
            $node = $node->filter(".price > li.price-current");
            return self::preparePrice($node->text());
        } catch (\InvalidArgumentException $e) {
            echo $e->getMessage() . "\n";
            return null;
        }
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

    protected static function extractLink(Crawler $node): ?string
    {
        try {
            $link = $node->filter(".item-info .item-title")->link()->getUri();
            if ($link) return $link;
        } catch (\InvalidArgumentException $e) {
            echo $e->getMessage();
        } catch (\Exception $e) {
            $e->getMessage();
        }

        return null;
    }

    protected static function extractModelNumber(Crawler $node): ?string
    {
        $node = $node->filter(".item-info .item-features > li");
        $values = $node->each(function(Crawler $node) {
            $dataToReturn = [];
            $dataToReturn["key"] = $node->filter("strong")->text();
            $dataToReturn["value"] = $node->text();

            return $dataToReturn;
        });

        foreach($values as $value)
            if (self::modelNumberKey($value["key"]))
                return self::removeModel($value["value"]);
        return null;
    }

    protected static function modelNumberKey(?string $modelNominee): bool
    {
        $pattern = "~Model\s*#\s*:\s*~i";
        $matches = [];
        preg_match($pattern, $modelNominee, $matches);

        if (count($matches) > 0)
            return true;
        return false;
    }

    protected static function removeModel(string $modelNumberString): ?string
    {
        $pattern = "~Model\s*#\s*:\s*(.+)~i";
        $matches = [];
        preg_match($pattern, $modelNumberString, $matches);
        if (count($matches) > 0)
            return trim($matches[1]);
        return null;
    }

    protected function prepareSearchUrl(string $searchTerm): string
    {
        return self::$baseUrl . "p/pl?d=" . $searchTerm;
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