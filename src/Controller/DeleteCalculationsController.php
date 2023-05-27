<?php
/* 
    What this does
        This controller handles the `/delete-calculations` route.
        It fetches all calculations from the database using the findAll() method.
        We then loop over each calculation and delete it.
        We then redirect to the homepage to show that there are no more calculations.
*/

namespace App\Controller;

use App\Entity\VatCalculation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class DeleteCalculationsController extends AbstractController
{
    public function new(EntityManagerInterface $entityManager): Response
    {
        $calculations = $entityManager->getRepository(VatCalculation::class)->findAll();

        foreach ($calculations as $calculation) {
            $entityManager->remove($calculation);
        }
        $entityManager->flush();

        return $this->redirectToRoute('index');
    }
}
