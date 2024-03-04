<?php

namespace App\Controller\AdminCompany;

use App\Repository\BillingsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class HomeController extends AbstractController
{

    private array $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    public function __construct()
    {

    }
    public function getInvoicesPerMonth(BillingsRepository $billingsRepository): array
    {
        $actualCompanyId = $this->getUser()->getCompany()->getId();
        $invoices = $billingsRepository->findBy(['type' => 'invoice', 'company' => $actualCompanyId]);
        $invoicesPerMonth = [];

        foreach ($this->months as $month) {
            $invoicesPerMonth[$month] = 0;
        }
        foreach ($invoices as $invoice) {
            $month = $invoice->getCreatedAt()->format('F');
            if (!isset($invoicesPerMonth[$month])) {
                $invoicesPerMonth[$month] = 0;
            }
            $invoicesPerMonth[$month]++;
        }
        return $invoicesPerMonth;
    }

    public function getBillings(BillingsRepository $billingsRepository):array
    {
        $actualCompanyId = $this->getUser()->getCompany()->getId();
        $quotes = $billingsRepository->findBy(['company' => $actualCompanyId]);
        $quotesPerMonth = [];
        foreach ($this->months as $month) {
            $quotesPerMonth[$month] = 0;
        }
        foreach ($quotes as $quote) {
            $month = $quote->getCreatedAt()->format('F');
            if (!isset($quotesPerMonth[$month])) {
                $quotesPerMonth[$month] = 0;
            }
            $quotesPerMonth[$month]++;
        }
        return $quotesPerMonth;
    }

    public function getNewClients(UserRepository $userRepository):array
    {
        //it's all users with company_id = $this->getUser()->getCompany()->getId() and role = ROLE_CLIENT
        $actualCompany = $this->getUser()->getCompany();
        $clients = $userRepository->findByCompanyAndRole($actualCompany, 'ROLE_USER');
        $clientsPerMonth = [];
        foreach ($this->months as $month) {
            $clientsPerMonth[$month] = 0;
        }
        foreach ($clients as $client) {
            $month = $client->getCreatedAt()->format('F');
            if (!isset($clientsPerMonth[$month])) {
                $clientsPerMonth[$month] = 0;
            }
            $clientsPerMonth[$month]++;
        }
        return $clientsPerMonth;
    }

    #[Route('/home', name: 'app_home')]
    public function index(ChartBuilderInterface $chartBuilder, BillingsRepository $billingsRepository,UserRepository $userRepository): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $signedQuotes = $this->getInvoicesPerMonth($billingsRepository);
        $quotes = $this->getBillings($billingsRepository);
        $clients = $this->getNewClients($userRepository);
        $chart->setData([
            'labels' => $this->months,
            'datasets' => [
                [
                    'label' => 'Devis signés par mois',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => array_values($signedQuotes),
                ],
                [
                    'label' => 'Devis émis par mois',
                    'backgroundColor' => 'rgb(54, 162, 235)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'data' => array_values($quotes),
                ],
                [
                    'label' => 'Nouveaux clients par mois',
                    'backgroundColor' => 'rgb(75, 192, 192)',
                    'borderColor' => 'rgb(75, 192, 192)',
                    'data' => array_values($clients),
                ]
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);
        return $this->render('home/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
