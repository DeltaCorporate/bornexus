<?php

namespace App\Controller\AccountantCompany;

use App\Entity\Billing;
use App\Repository\BillingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class AccountantController extends AbstractController
{
    private array $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
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

    #[Route('/', name: 'app_accountant')]
    public function index(ChartBuilderInterface $chartBuilder, BillingsRepository $billingsRepository): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $signedQuotes = $this->getInvoicesPerMonth($billingsRepository);
        $quotes = $this->getBillings($billingsRepository);
//        dd($signedQuotes, $quotes);
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
        return $this->render('accountant/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
