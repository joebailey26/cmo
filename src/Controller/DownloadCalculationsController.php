<?php
/* 
    What this does
        This controller handles the `/download-calculations` route.
        It fetches all calculations from the database using the findAll() method.
        We then loop over each calculation and add it to a CSV.
        We then download that CSV.
*/

namespace App\Controller;

use App\Entity\VatCalculation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class DownloadCalculationsController extends AbstractController
{
    public function new(EntityManagerInterface $entityManager): Response
    {
        $calculations = $entityManager->getRepository(VatCalculation::class)->findAll();

        $csvData = [];
        // Set up the column titles
        $csvData[] = [
            'ID',
            'Input: Monetary Value',
            'Input: VAT Rate',
            'Input: Is VAT included?',
            'Output: Monetary value excluding VAT',
            'Output: Amount of VAT',
            'Output: Monetary value including VAT'
        ];

        foreach ($calculations as $calculation) {
            // Add the $calculation to the CSV
            $csvData[] = [
                $calculation->getId(),
                $calculation->getV(),
                $calculation->getR(),
                $calculation->getIsVatIncluded(),
                $calculation->getResultWithoutVat(),
                $calculation->getAmountOfVat(),
                $calculation->getResultWithVat()
            ];
        }
        $entityManager->flush();

        // Download the CSV
        $csvFileName = 'vat-calculations.csv';
        $csvFile = fopen($csvFileName, 'w');
        foreach ($csvData as $csvRow) {
            fputcsv($csvFile, $csvRow);
        }
        fclose($csvFile);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $csvFileName . '"');
        $response->setContent(file_get_contents($csvFileName));

        return $response;
    }
}
