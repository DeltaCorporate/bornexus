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

    private function getCaPerMonth(BillingsRepository $billingsRepository): array
    {
        //get all the billings of the company type invoice
        $actualCompany = $this->getUser()->getCompany();
        $invoices = $billingsRepository->findBy(['type' => 'invoice', 'company' => $actualCompany]);
        $caPerMonth = [];
        foreach ($this->months as $month) {
            $caPerMonth[$month] = 0;
        }
        foreach ($invoices as $invoice) {
            $month = $invoice->getCreatedAt()->format('F');
            if (!isset($caPerMonth[$month])) {
                $caPerMonth[$month] = 0;
            }
            $caPerMonth[$month] += $invoice->calculTotalPrices()->getPriceTtc();
        }
        return $caPerMonth;
    }


    #[Route('/', name: 'app_accountant')]
    public function index(ChartBuilderInterface $chartBuilder, BillingsRepository $billingsRepository): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $caPerMonth = $this->getCaPerMonth($billingsRepository);
        $chart->setData([
            'labels' => $this->months,
            'datasets' => [
                [
                    'label' => 'Chiffre d\'affaire par mois',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => array_values($caPerMonth),
                ]
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 10000,
                ],
            ],
        ]);
        return $this->render('home/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
