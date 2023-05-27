<?php
/*
    What this does
        We want to test the calculation form to ensure that valid inputs are processed correctly and invalid inputs are not.
*/


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewCalculationControllerTest extends WebTestCase
{
    public function testValidInput()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/new-calculation');

        $form = $crawler->selectButton('Calculate VAT')->form();
        $form['calculate_vat_form[v]'] = 100;
        $form['calculate_vat_form[r]'] = 20;
        $form['calculate_vat_form[isVatIncluded]'] = true;

        $client->submit($form);

        $response = $client->getResponse();
        $this->assertResponseRedirects();

        $redirectUrl = $response->headers->get('Location');
        $this->assertMatchesRegularExpression('/\/\?highlightId=\d+/', $redirectUrl);
    }

    public function testInvalidInput()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/new-calculation');

        $form = $crawler->selectButton('Calculate VAT')->form();
        $form['calculate_vat_form[v]'] = 'test';
        $form['calculate_vat_form[r]'] = '';

        $client->submit($form);
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('label[for=calculate_vat_form_v] + ul li', 'Please enter a number.');
        $this->assertSelectorTextContains('label[for=calculate_vat_form_r] + ul li', 'This value should not be blank.');
    }
}
