<?php
declare(strict_types = 1);

namespace Attogram\Body;

/** @var BodyMassInfoTable $this */

$height = ($this->human->getHeight() > 0) ? $this->human->getHeight() : '';

$age = ($this->human->getAge() > 0) ? $this->human->getAge() : '';

$checked = ' checked="checked"';
$checkM = (isset($_GET['x']) && $_GET['x'] == 'm') ? $checked : '';
$checkF = (isset($_GET['x']) && $_GET['x'] == 'f') ? $checked : '';

?>
<div class="collapse show" id="options">
    <form>
        <div class="row mx-5 px-2">
            <div class="col">
                <label for="h">Height:</label>
                <input id="h" name="h" title="Height" type="text" size="4" maxlength="5" value="<?= $height ?>" />meters
            </div>
            <div class="col">
                <label for="a">Age:</label>
                <input id="a" name="a" title="Age" type="text" size="4" maxlength="5" value="<?= $age ?>" />years
            </div>
            <div class="col">
                <label>Sex:</label>
                <input type="radio" title="male" name="x" value="m" <?= $checkM; ?>>male
                <input type="radio" title="female" name="x" value="f" <?= $checkF; ?>>female
            </div>
        </div>
        <div class="row mx-5 px-2 bg-light">
            <div class="col">
                <em>Options:</em>
            </div>
            <div class="col">
                <label>Range:</label>
                <input id="s" name="s" title="Table start" size="4" maxlength="5" value="<?=
                    $this->startMass;
                ?>" />-<input id="e" name="e" title="Table end" size="4" maxlength="5" value="<?=
                    $this->endMass;
                ?>" />kg
            </div>
            <div class="col">
                <label for="i">Increment:</label>
                <input id="i" name="i" title="Increment" size="3" maxlength="6" value="<?= $this->increment; ?>" />kg
            </div>
        </div>
        <div class="row mx-5 px-2">
            <div class="col">
                <input type="submit" value="          Update Table          " />
            </div>
        </div>
    </form>
</div>
<div class="righty">
    <a data-toggle="collapse" href="#options" aria-expanded="false" aria-controls="options">Toggle form</a>
</div>
