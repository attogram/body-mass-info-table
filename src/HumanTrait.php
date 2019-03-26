<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * Trait HumanTrait
 * @package Attogram\Body
 */
trait HumanTrait
{
    /** @var AverageHuman */
    protected $human;

    /**
     * @param AverageHuman $human
     */
    public function setHuman(AverageHuman $human)
    {
        $this->human = $human;
    }

    /**
     * @return bool
     */
    protected function isValidHuman()
    {
        if ($this->human instanceof AverageHuman) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function isValidHumanHeight()
    {
        if ($this->isValidHuman() && Util::isValidFloat($this->human->getHeightMeters())) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function isValidHumanMass()
    {
        if ($this->isValidHuman() && Util::isValidFloat($this->human->getMassKilograms())) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function isValidHumanAge()
    {
        if ($this->isValidHuman() && Util::isValidFloat($this->human->getAge())) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function isValidHumanSex()
    {
        if ($this->isValidHuman() && in_array($this->human->getSex(), ['m','f'])) {
            return true;
        }
        return false;
    }
}
