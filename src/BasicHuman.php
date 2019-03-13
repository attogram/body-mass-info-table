<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * Basic Human
 */
class BasicHuman
{
    /** @var float $age - age, in years */
    protected $age = 0.0;

    /** @var float $height - length, in meters */
    protected $height = 0.0;

    /** @var float $mass - weight, in kilograms */
    protected $mass = 0.0;

    /** @var string $sex - sex, m=male f=female, u=unknown*/
    protected $sex = 'u';

    /**
     * @return float
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return float
     */
    public function getMass()
    {
        return $this->mass;
    }

    /**
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $age = (float) $age;
        if (Utils::isValidFloat($age)) {
            $this->age = $age;

            return;
        }
        $this->age = 0.0;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $height = (float) $height;
        if (Utils::isValidFloat($height)) {
            $this->height = $height;

            return;
        }
        $this->height = 0.0;
    }

    /**
     * @param mixed $mass
     */
    public function setMass($mass)
    {
        $mass = (float) $mass;
        if (Utils::isValidFloat($mass)) {
            $this->mass = $mass;

            return;
        }
        $this->mass = 0.0;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        if (in_array($sex, ['m', 'f'])) {
            $this->sex = $sex;

            return;
        }
        $this->sex = 'u';
    }
}
