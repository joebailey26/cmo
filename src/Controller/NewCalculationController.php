<?php
/*
    What this does
        This controller handles the /new-calculation route.
        We create the form from the CalculateVatForm class and either return the rendered form or process the form.
        We call handleRequest on the form object which validates the inputs.
        If the inputs are invalid, it returns the form with the appropriate error messages.
        If the inputs are valid, it gets the submitted data from the form, which is a new instance of the VatCalculation class.
        Then it passes it through to the EntityManagerInterface to persist the data in the database.
    SQL Injection
        We handle the isValid() method on the form which only allows data to be persisted if it passes validation.
*/

namespace App\Controller;

use App\Form\CalculateVatForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class NewCalculationController extends AbstractController
{
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CalculateVatForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vatCalculation = $form->getData();
            $entityManager->persist($vatCalculation);
            $entityManager->flush();
            // Pass this calculation to IndexController so that we can highlight it
            return $this->redirectToRoute('index', ['highlightId' => $vatCalculation->getId()]);
        }

        return $this->render('calculateVat.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
