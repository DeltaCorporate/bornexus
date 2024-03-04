<?php

namespace App\Pdf;

use App\Entity\Billing;
use IntlDateFormatter;
use Konekt\PdfInvoice\InvoicePrinter;

class BillingPdf
{
    private ?Billing $billing;
    public function __construct(Billing $billing)
    {
        $this->billing = $billing;
    }

    public function generate()
    {
        $formatter = new IntlDateFormatter(
            'fr_FR', // Locale
            IntlDateFormatter::LONG, // Style de la date
            IntlDateFormatter::NONE // Style de l'heure
        );


        $invoice = new InvoicePrinter(language: 'fr',currency: '€');
        $billing = $this->billing;
        $company = $billing->getCompany();
        $client = $billing->getUsers();
        $billingCompanyCatalogs=  $billing->getBillingsCompanyCatalogs();
        $billing->calculTotalPrices();
        /* Header settings */
        $invoice->setColor("#A8EB74");      // pdf color scheme
        $invoice->setNumberFormat(alignment: 'right');
        $invoice->setType(Billing::TYPE[$billing->getType()]);    // Invoice Type
        $invoice->setReference($billing->getTypeFirstLetter().$billing->getId());   // Reference
        $invoice->setDate($formatter->format($billing->getEmitedAt()));   //Billing Date
        $invoice->setFrom(array($company->getName(),$company->getAddress(),$company->getCountry().", ".$company->getZip()));
        $invoice->setTo(array($client->getFullName(),$client->getAddress()));

        foreach($billingCompanyCatalogs as $billingCompanyCatalog){
            $companyCatalog = $billingCompanyCatalog->getCompanyCatalog();
            $product = $companyCatalog->getProduct();
            $invoice->addItem(
                item: $product->getName(),
                description: $product->getDescription(),
                quantity: $billingCompanyCatalog->getQuantity(),
                vat: $billingCompanyCatalog->getPriceVat(),
                price: $billingCompanyCatalog->getPriceHt(),
                discount: $billingCompanyCatalog->getPriceDiscount(),
                total: $billingCompanyCatalog->getPriceTtc()
            );
        }


        $invoice->addTotal("Total Ht",$billing->getPriceHt());
        $invoice->addTotal("Tva",$billing->getPriceVat());
        $invoice->addTotal("Solde","-". $billing->getDiscountPrice());
        $invoice->addTotal("Total Ttc",$billing->getPriceTtcDiscounted(),true);

        if($billing->getStatus() === 'paid')
        $invoice->addBadge("Payé");

        $invoice->addTitle("Notes");

        $paymentMethod = $billing->getPaymentMethod();
        if($billing->getPaymentMethod() == 'deposit')
            $invoice->addParagraph('Règlement par Virement à l\'ordre de : '.$company->getName());
        if($paymentMethod == 'stripe')
            $invoice->addParagraph('Règlement par carte bancaire');
        $invoice->addParagraph($company->getTvaReason());
        $invoice->setFooternote($billing->getCompany()->getName());

        $invoice->render('example1.pdf','I');
        /* I => Display on browser, D => Force Download, F => local path save, S => return document as string */

    }
}