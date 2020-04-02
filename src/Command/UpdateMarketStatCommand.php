<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\IcomHomeStatistic;
use App\Service\Model\HomeAdvData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class UpdateMarketStatCommand extends Command
{
    protected static $defaultName = 'market-stat:update';
    private $icomHomeStatistic;

    public function __construct(
        string $name = null,
        IcomHomeStatistic $icomHomeStatistic
    )
    {
        parent::__construct($name);
        $this->icomHomeStatistic = $icomHomeStatistic;
    }


    protected function configure()
    {
        $this
            ->setDescription("Update home market statistics")
            ->setHelp("This command loads the new data from the market and refresh in the database");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $iComStat = $this->icomHomeStatistic->getMarketStatistics("/lista/elado+lakas+diosd");
        /** @var HomeAdvData $homeAdvData */
        foreach ($iComStat as $homeAdvData) {
            $output->writeln("=========================================");
            $output->writeln("URL: ".IcomHomeStatistic::ICOM_DOMAIN."/".$homeAdvData->getId());
            $output->writeln("Ár orig: ".$homeAdvData->getPrice());
            $output->writeln("Ár: ".$homeAdvData->getNumericPrice());
            $output->writeln("Méret: ".$homeAdvData->getSize());
            $output->writeln("Szobaszám: ".$homeAdvData->getRoomNumber());
            $output->writeln("Közvetítő: ".$homeAdvData->getAgentName());
            $output->writeln("Leírás:".$homeAdvData->getDescription());
        }
        /*
        $output->writeln("Refreshing market stat...");
        $client = HttpClient::create();
        $listResponse = $client->request('GET','https://ingatlan.com/lista/elado+lakas+diosd');
        $listCrawler = new Crawler($listResponse->getContent());
        $attributes =
            $listCrawler
                ->filter(".js-listing")
                ->extract(["data-id"]);
        foreach ($attributes as $advId) {
            $output->writeln("===========================================");
            $output->writeln("ID: ".$advId);
            $advResponse = $client->request('GET','https://ingatlan.com/'.$advId);
            $advCrawler = new Crawler($advResponse->getContent());
            $mainData =
                $advCrawler
                    ->filter(".listing-parameters");
            $housePrice =
                $mainData
                    ->children(".parameter-price > .parameter-value")
                    ->text();
            $houseRooms =
                $mainData
                    ->children(".parameter-room > .parameter-value")
                    ->text();
            $houseSize =
                $mainData
                    ->children(".parameter-area-size > .parameter-value")
                    ->text();
            $output->writeln("Price: ".$housePrice);
            $output->writeln("Size: ".$houseSize);
            $output->writeln("Room number: ".$houseRooms);
        }
        */


        return 0;
    }


}