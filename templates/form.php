<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * @var Form $this
 */
?>
<form>
    <div class="row mx-5 px-2 border">
        <div class="col">
            <input type="submit" value="  Update  " />
        </div>
        <div class="col nobr">
            <label for="h">Height:</label>
            <br />
            <input id="h" name="h" title="Height" type="text" size="4" maxlength="5" value="<?=
                $this->getData('height')
            ?>" /> meters
        </div>
        <div class="col nobr">
            <label for="a">Age:</label>
            <br />
            <input id="a" name="a" title="Age" type="text" size="4" maxlength="5" value="<?=
                $this->getData('age')
            ?>" /> years
        </div>
        <div class="col nobr">
            <label for="x">Sex:</label>
            <br />
            <input type="radio" title="male" name="x" id="x" value="m" <?=
                $this->getData('checkM')
            ?>> Male
            <br />
            <input type="radio" title="female" name="x" id="x" value="f" <?=
                $this->getData('checkF')
            ?>> Female
        </div>
    </div>
    <div class="collapse show" id="options">
        <div class="row mx-5 mt-3 px-2 bg-light border">
            <div class="col nobr pt-3">
                <label for="s">Weight Range:</label><label for="e"></label>
                <br />
                <input id="s" name="s" title="Table start" size="4" maxlength="5" value="<?=
                    $this->getData('startMass')
                ?>" />-<input id="e" name="e" title="Table end" size="4" maxlength="5" value="<?=
                    $this->getData('endMass')
                ?>" /> kg
            </div>
            <div class="col nobr pt-3">
                <label for="i">Increment:</label>
                <br />
                <input id="i" name="i" title="Increment" size="3" maxlength="6" value="<?=
                    $this->getData('increment')
                ?>" /> kg
            </div>
            <div class="col nobr pt-3">
                <label for="r">Repeat Header:</label>
                <br />
                every <input id="r" name="r" title="Repeat Header" size="2" maxlength="5" value="<?=
                    $this->getData('repeatHeader')
                ?>" /> rows
            </div>
            <div class="col nobr pt-3">
                <label>Body Mass Index (BMI) Formula:</label>
                <br />
                <input type="radio" title="orig" name="Quetelet 1830s" id="bmi" value="1" checked="checked" />
                    Quetelet 1830s:
                    <small>BMI = Weight_kg / (Height_meters ^2)</small>
                <br />
                <input type="radio" title="orig" name="Trefethen 2013" id="bmi" value="2" />
                    Trefethen 2013:
                <small>BMI = (1.3 * Weight_kg) / (Height_meters ^2.5) </small>
                <br />
            </div>
            <div class="col nobr pt-3">
                <label>Body Fat Percentage (BFP) Estimation Formula:</label>
                <br />
                <input type="radio" title="Jackson 2002" name="bf" id="bf" value="1" checked="checked" />
                    Jackson 2002:
                    <small>BFP = (1.39 * BMI) + (0.16 * Age) – (10.34 * [M=1,F=0]) – 9.0</small>
                <br />
                <input type="radio" title="Deurenberg 1998" name="bf" id="bf" value="2" />
                    Deurenberg 1998:
                    <small>BFP = (1.29 * BMI) + (0.20 * Age) – (11.40 * [M=1,F=0]) – 8.03</small>
                <br />
                <input type="radio" title="Gallagher 1996" name="bf" id="bf" value="3" />
                    Gallagher 1996:
                    <small>BFP = (1.46 * BMI) + (0.14 * Age) – (11.60 * [M=1,F=0]) – 104</small>
                <br />
                <input type="radio" title="Deurenberg 1991" name="bf" id="bf" value="4" />
                    Deurenberg 1991:
                    <small>BFP = (1.20 * BMI) + (0.23 * Age) – (10.80 * [M=1,F=0]) – 5.42</small>
                <br />
                <input type="radio" title="Jackson-Pollock 1984" name="bf" id="bf" value="5" />
                    Jackson-Pollock 1984:
                    <small>BFP = (1.61 * BMI) + (0.13 * Age) – (12.10 * [M=1,F=0]) – 13.95</small>
            </div>
            <div class="col nobr pt-3">
                <label>Basal Metablic Rate (BMR) Estimation Formula:</label>
                <br />
                <input type="radio" title="Katch-McArdle" name="bmr" id="bmr" value="1" checked="checked" />
                    Katch-McArdle:
                    <small>BMR = 370 + (21.6 * (Weight_kg * (1 - BFP)))</small>
                <br />
            </div>
        </div>
    </div>
    <div class="righty">
        <a data-toggle="collapse" href="#options" aria-expanded="false" aria-controls="options">Toggle Options</a>
    </div>
</form>
