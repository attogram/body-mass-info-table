<?php
/**
 * Form Template
 *
 * @var Form $this
 */
declare(strict_types = 1);

namespace Attogram\Body;

use Attogram\Body\Equation\BasalMetabolicRate;
use Attogram\Body\Equation\BodyFatPercentage;
use Attogram\Body\Equation\BodyMassIndex;

?>
<form>
    <div class="row mx-5 px-2 border">
        <div class="col pb-2">
            <input type="submit" value="     Update Table     " />
        </div>
        <div class="col nobr pb-2">
            <label for="h">Height:</label>
            <br />
            <input id="h" name="h" title="Height" type="text" size="4" maxlength="5" value="<?=
                $this->getData('height') ?>" /> meters
        </div>
        <div class="col nobr pb-2">
            <label for="a">Age:</label>
            <br />
            <input id="a" name="a" title="Age" type="text" size="4" maxlength="5" value="<?=
                $this->getData('age') ?>" /> years
        </div>
        <div class="col nobr">
            <label for="x">Sex:</label>
            <br />
            <input type="radio" title="male" name="x" id="x" value="m" <?=
                $this->getData('checkM') ?>> Male
            <br />
            <input type="radio" title="female" name="x" id="x" value="f" <?=
                $this->getData('checkF') ?>> Female
        </div>
    </div>
    <div class="row mx-4 px-4">
        <a data-toggle="collapse" href="#options" aria-expanded="false" aria-controls="options">
            <small>
                &nbsp; + Setup Table:
                Weight Range,
                Increment,
                Header repeat
            </small>
        </a>
    </div>
    <div class="collapse hide mb-3" id="options">
        <div class="row mx-5 px-2 bg-light">
            <div class="col nobr pt-3">
                <label for="s">Weight Range:</label><label for="e"></label>
                <br />
                <input id="s" name="s" title="Table start" size="4" maxlength="5" value="<?=
                    $this->getData('startMass')
                ?>" />-<input id="e" name="e" title="Table end" size="4" maxlength="5" value="<?=
                    $this->getData('endMass') ?>" /> kilograms
            </div>
            <div class="col nobr pt-3">
                <label for="i">Increment:</label>
                <br />
                <input id="i" name="i" title="Increment" size="3" maxlength="6" value="<?=
                    $this->getData('increment') ?>" /> kilograms
            </div>
            <div class="col nobr pt-3">
                <label for="r">Header repeat:</label>
                <br />
                every <input id="r" name="r" title="Repeat Header" size="2" maxlength="5" value="<?=
                    $this->getData('repeatHeader') ?>" /> rows
            </div>
        </div>
    </div>
    <div class="row mx-4 px-4">
        <a data-toggle="collapse" href="#equations" aria-expanded="false" aria-controls="equations">
            <small>
                &nbsp; + Setup Equations:
                Body Mass Index (BMI),
                Body Fat Percentage (BFP),
                Basal Metabolic Rate (BMR)
            </small>
        </a>
    </div>
    <div class="collapse hide" id="equations">
        <div class="row mx-5 px-2 bg-light">
            <div class="col nobr pt-3">
                <label>BMI - Body Mass Index Equation:</label>
                <br />
                <?= $this->radioBunch(BodyMassIndex::getEquations(), 'equationBodyMassIndex', 'bmi') ?>
            </div>
            <div class="col nobr pt-3">
                <label>BFP - Body Fat Percentage Equation:</label>
                <br />
                <?= $this->radioBunch(BodyFatPercentage::getEquations(), 'equationBodyFatPercentage', 'bfp') ?>
            </div>
            <div class="col nobr pt-3">
                <label>BMR - Basal Metabolic Rate Equation:</label>
                <br />
                <?= $this->radioBunch(BasalMetabolicRate::getEquations(), 'equationBasalMetabolicRate', 'bmr') ?>
            </div>
        </div>
    </div>
</form>
