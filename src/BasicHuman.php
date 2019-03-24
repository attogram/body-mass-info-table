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

    /** @var string $sex - sex, m=male f=female */
    protected $sex = '';

    /**
     * @return float
     */
    public function getAge()
    {
        return (float) $this->age;
    }

    /**
     * @return float
     */
    public function getHeightMeters()
    {
        return (float) $this->height;
    }

    /**
     * @return float
     */
    public function getHeightCentimeters()
    {
        return (float) $this->height * 100;
    }

    /**
     * @return float
     */
    public function getMassKilograms()
    {
        return (float) $this->mass;
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
        if (Util::isValidFloat($age)) {
            $this->age = $age;

            return;
        }
        $this->age = 0.0;
    }

    /**
     * @return bool
     */
    public function isAdult()
    {
        if ($this->age > 20.99) {
            return true;
        }
        return false;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $height = (float) $height;
        if (Util::isValidFloat($height)) {
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
        if (Util::isValidFloat($mass)) {
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
        $this->sex = '';
    }

    /**
     * @return bool
     */
    public function isFemale()
    {
        if ($this->sex == 'f') {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isMale()
    {
        if ($this->sex == 'm') {
            return true;
        }
        return false;
    }
}
