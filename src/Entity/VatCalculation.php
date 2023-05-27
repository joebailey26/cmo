<?php
/*
    What this does
        This is a class of VAT Calculation.
        We use a special commented markup for Doctrine which handles database mapping for us.
        Because this is in the entity folder, we can run `php bin/console make:migration` to make a migration.
        We can then run `php bin/console doctrine:migrations:migrate` to perform the migrations.
        A migration makes sure our database has the correct columns to handle this data.
    SQL Injection
        Doctrine handles SQL parameterization, making SQL injection attacks less likely
*/

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class VatCalculation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $v;

    /**
     * @ORM\Column(type="float")
     */
    private $r;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVatIncluded;

    // Getters and setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getV(): ?float
    {
        return $this->v;
    }

    public function setV(float $v): self
    {
        $this->v = $v;

        return $this;
    }

    public function getR(): ?float
    {
        return $this->r;
    }

    public function setR(float $r): self
    {
        $this->r = $r;

        return $this;
    }

    public function getIsVatIncluded(): ?bool
    {
        return $this->isVatIncluded;
    }

    public function setIsVatIncluded(bool $isVatIncluded): self
    {
        $this->isVatIncluded = $isVatIncluded;

        return $this;
    }

    /*
        We perform the calculations on the fly rather than storing them in the database.
        This allows us to add or change calculations in the future without having to update all items in the database.
    */

    public function getResultWithVat(): ?float
    {
        /*
            If VAT is included in the original value, we just return the original value rounded to 2 decimal places.
            We use a return early style to make the code more readable.
        */
        if ($this->isVatIncluded) {
            return round($this->getV(), 2);
        }
        /*
            If VAT is not included, we work out the amount to add, which is v * r * .01.
            We're asking for the percentage so have to times it by .01 to get a decimal.
            We round this to 2 decimal places too.
        */
        return round($this->getV() + $this->getV() * $this->getR() * .01, 2);
    }

    public function getResultWithoutVat(): ?float
    {
        /*
            If VAT is included, we divide the original value by 1 + percentage of VAT.
            We round the result.
        */
        if ($this->isVatIncluded) {
            return round($this->getV() / (1 + $this->getR() * .01), 2);
        }
        /*
            If VAT is not included, we can just return the original value.
        */
        return round($this->getV(), 2);
    }

    public function getAmountOfVat(): ?float
    {
        /*
            The amount of VAT is just the result with VAT minus the result without.
        */
        return round($this->getResultWithVat() - $this->getResultWithoutVat(), 2);
    }
}
