<?php


namespace App\Forms\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Payment
{

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=19)
     */
    private $card_number;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=64)
     */
    private $cardholder_name;

    /**
     * @Assert\NotBlank
     */
    private $card_type;

    /**
     * @Assert\NotBlank
     */
    private $expiration_date;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=3)
     */
    private $csv;

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->card_number;
    }

    /**
     * @param mixed $card_number
     */
    public function setCardNumber($card_number): void
    {
        $this->card_number = $card_number;
    }

    /**
     * @return mixed
     */
    public function getCardholderName()
    {
        return $this->cardholder_name;
    }

    /**
     * @param mixed $cardholder_name
     */
    public function setCardholderName($cardholder_name): void
    {
        $this->cardholder_name = $cardholder_name;
    }

    /**
     * @return mixed
     */
    public function getCardType()
    {
        return $this->card_type;
    }

    /**
     * @param mixed $card_type
     */
    public function setCardType($card_type): void
    {
        $this->card_type = $card_type;
    }

    /**
     * @return mixed
     */
    public function getExpirationDate()
    {
        return $this->expiration_date;
    }

    /**
     * @param mixed $expiration_date
     */
    public function setExpirationDate($expiration_date): void
    {
        $this->expiration_date = $expiration_date;
    }

    /**
     * @return mixed
     */
    public function getCsv()
    {
        return $this->csv;
    }

    /**
     * @param mixed $csv
     */
    public function setCsv($csv): void
    {
        $this->csv = $csv;
    }


}