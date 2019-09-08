<?php

declare(strict_types=1);

namespace BluMS\Domain\Model\Order\Entity;

class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="smallint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="customer_name", type="string", length=50)
     */
    private $customerName;

    /**
     * @ORM\Column(name="car_make", type="string", length=50)
     */
    private $carMake;

    /**
     * @ORM\Column(name="car_model", type="string", length=50)
     */
    private $carModel;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @param mixed $customerName
     */
    public function setCustomerName($customerName): void
    {
        $this->customerName = $customerName;
    }

    /**
     * @return mixed
     */
    public function getCarMake()
    {
        return $this->carMake;
    }

    /**
     * @param mixed $carMake
     */
    public function setCarMake($carMake): void
    {
        $this->carMake = $carMake;
    }

    /**
     * @return mixed
     */
    public function getCarModel()
    {
        return $this->carModel;
    }

    /**
     * @param mixed $carModel
     */
    public function setCarModel($carModel): void
    {
        $this->carModel = $carModel;
    }
}
