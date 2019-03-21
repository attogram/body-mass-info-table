<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * @var Form $this
 */
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
    <div class="righty">
        <a data-toggle="collapse" href="#options" aria-expanded="false" aria-controls="options">Toggle Options</a>
    </div>
    <div class="collapse show" id="options">
        <div class="row mx-5 px-2 bg-light border">
            <div class="col nobr pt-3">
                <label for="s">Weight Range:</label><label for="e"></label>
                <br />
                <input id="s" name="s" title="Table start" size="4" maxlength="5" value="<?=
                    $this->getData('startMass')
                ?>" />-<input id="e" name="e" title="Table end" size="4" maxlength="5" value="<?=
                    $this->getData('endMass') ?>" /> kg
            </div>
            <div class="col nobr pt-3">
                <label for="i">Increment:</label>
                <br />
                <input id="i" name="i" title="Increment" size="3" maxlength="6" value="<?=
                    $this->getData('increment') ?>" /> kg
            </div>
            <div class="col nobr pt-3">
                <label for="r">Repeat Header:</label>
                <br />
                every <input id="r" name="r" title="Repeat Header" size="2" maxlength="5" value="<?=
                    $this->getData('repeatHeader') ?>" /> rows
            </div>
            <div class="col nobr pt-3">
                <label>Body Mass Index (BMI) Formula:</label>
                <br />
                <input type="radio" title="orig" name="Quetelet 1832" id="bmi" value="1" checked="checked" />
                    Quetelet 1832:
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
                <input type="radio" title="Katch-McArdle 2006" name="bmr" id="bmr" value="1" checked="checked" />
                    Katch-McArdle 2006:
                    <small>BMR = 370 + (21.6 * (Weight_kg * (1 - BFP)))</small>
                <br />
                <input type="radio" title="Katch-McArdle-Hybrid Orlcam 20??" name="bmr" id="bmr" value="5" />
                Katch-McArdle-Hybrid Orlcam 20??:
                <small>
                    BMR = (370 * (1 - BFP)) + (21.6 * (Weight_kg * (1 - BFP))) + (6.17 * (Weight_kg * BFP))
                </small>
                <br />
                <input type="radio" title="Harris-Benedict 1919" name="bmr" id="bmr" value="2" />
                    Harris-Benedict 1919:
                    <small>
                        Male BMR = (13.7516 * Weight_kg) + (5.0033 * Height_cm) - (6.755  * Age) + 66.473
                        ~~ Female BMR = (9.5634 * Weight_kg) + (1.8496 * Height_cm) - (4.6756 * Age) + 655.0955
                    </small>
                <br />
                <input type="radio" title="Harris-Benedict-Revised Roza-Shizgal 1984" name="bmr" id="bmr" value="4" />
                    Harris-Benedict-Revised Roza-Shizgal 1984:
                    <small>
                        Male BMR = (13.397 * Weight_kg) + (4.799 * Height_cm) - (5.677 * Age) + 88.362
                        ~~ Female BMR = (9.247 * Weight_kg) + (3.098 * Height_cm) - (4.330 * Age) + 447.593
                    </small>
                <br />
                <input type="radio" title="Mifflin-St Jeor 1990" name="bmr" id="bmr" value="5" />
                    Mifflin-St Jeor 1990:
                    <small>
                        Male BMR = (10 * Weight_kg) + (6.25 * Height_cm) - (5 * Age) + 5
                        ~~ Female BMR = (10 * Weight_kg) + (6.25 * Height_cm) - (5 * Age) - 161
                    </small>
                <br />
                <input type="radio" title="Cunningham 1980" name="bmr" id="bmr" value="6" />
                    Cunningham 1980:
                    <small>BMR = 500 + (22 * (Weight_kg * (1 - BFP)))</small>
                <br />


            </div>
        </div>
    </div>
</form>
