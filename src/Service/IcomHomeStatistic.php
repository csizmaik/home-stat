<?php
namespace App\Service;

use App\Service\Model\HomeAdvData;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IcomHomeStatistic
{
    const ICOM_DOMAIN = "https://ingatlan.com";

    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return array<HomeAdvData>
     */
    public function getMarketStatistics(string $marketFilter): array
    {
        $marketStat = [];
        $listResponse = $this->httpClient->request('GET',self::ICOM_DOMAIN.$marketFilter);
        $listCrawler = new Crawler($listResponse->getContent());
        $attributes =
            $listCrawler
                ->filter(".js-listing")
                ->extract(["data-id"]);
        foreach ($attributes as $advId) {
            $homeAdvData = $this->getAdvData($advId);
            $marketStat[$advId] = $homeAdvData;
        }

        return $marketStat;
    }

    private function getAdvData(string $advId): HomeAdvData
    {
        $advResponse = $this->httpClient->request('GET',self::ICOM_DOMAIN.'/'.$advId);
        $advCrawler = new Crawler($advResponse->getContent());
        $mainData = $advCrawler->filter(".listing-parameters");
        $housePrice = $this->getMainData($mainData, ".parameter-price > .parameter-value");
        $houseNumericPrice = $this->getNumericPrice($housePrice);
        $houseRooms = $this->getMainData($mainData, ".parameter-room > .parameter-value");
        $houseSize = $this->getMainData($mainData, ".parameter-area-size > .parameter-value");
        $description = $advCrawler->filter(".long-description")->text();
        $agentNode = $advCrawler->filter(".agent-name");
        $agent = null;
        if ($agentNode->count()) {
            $agent = $agentNode->text();
        }
        $homeAdvData = new HomeAdvData($advId, $housePrice, $houseSize);
        $homeAdvData
            ->setRoomNumber($houseRooms)
            ->setDescription($description)
            ->setNumericPrice($houseNumericPrice)
            ->setAgentName($agent);

        return $homeAdvData;
    }

    private function getMainData(Crawler $crawler, string $filter): ?string
    {
        return $crawler
                ->children($filter)
                ->text();
    }

    private function getNumericPrice(string $stringPrice): float
    {
        $multipleMillon = false;
        if (strpos($stringPrice,'millió') !== false) {
            $multipleMillon = true;
        }
        $stringPrice = str_replace(['Ft','millió',','],['','','.'],$stringPrice);
        $numericPrice = floatval(trim($stringPrice));
        if ($multipleMillon) {
            $numericPrice = $numericPrice * 1000000;
        }

        return $numericPrice;
    }
}