<?php
/* 
    What this does
        This controller handles the `/` route.
        It fetches all calculations from the database using the findAll() method.
        We pass this array through to the twig template.
*/

namespace App\Controller;

use App\Entity\VatCalculation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class IndexController extends AbstractController
{
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $calculations = $entityManager->getRepository(VatCalculation::class)->findAll();
        /*
            We can pass a highlighted VatCalculation through from the form
            to show a user what they have just submitted.
            If we do get a highlightId in the query string, we try to find this calculation from the database.
            This ensures that only ids that are associated with a calculation get passed through.
            We then pass it through to the twig template to let it be highlighted
        */
        $highlightId = $request->query->get('highlightId');

        $highlightedCalculation = null;
        if ($highlightId !== null) {
            $highlightedCalculation = $entityManager->getRepository(VatCalculation::class)->find($highlightId);
        }

        return $this->render('index.html.twig', [
            'calculations' => $calculations,
            'highlightedCalculation' => $highlightedCalculation,
        ]);
    }
}
