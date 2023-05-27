<?php
/* 
    What this does
        This builds a form with 4 inputs, `v`, `r`, `isVatIncluded` and `save`.
    SQL Injection
        We add constraints here so that we only accept numbers and not text.
        This is browser validated too on the number inputs by setting `html5` to true.
        By using Doctrine, the checkbox's data is constrained to a boolean anyway.
*/

namespace App\Form;

use App\Entity\VatCalculation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CalculateVatForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('v', NumberType::class, [
                'html5' => true,
                'label' => '£',
                'constraints' => [
                    new NotBlank(),
                    new Regex('/^\d+$/'),
                ],
            ])
            ->add('r', NumberType::class, [
                'html5' => true,
                'label' => '%',
                'constraints' => [
                    new NotBlank(),
                    new Regex('/^\d+$/'),
                ],
            ])
            ->add('isVatIncluded', CheckboxType::class, [
                'required' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Calculate VAT']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        /*
            We let symfony know that this form is bound to the VatCalculation class.
        */
        $resolver->setDefaults([
            'data_class' => VatCalculation::class
        ]);
    }
}
