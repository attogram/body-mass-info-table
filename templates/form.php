<?php
declare(strict_types = 1);

namespace Attogram\Body;

/** @var BodyMassInfoChart $this */
?>
<form>
    <input type="submit" value="          Update Chart          " />
    &nbsp;
    <nobr><label for="h">Height:</label>
    <input id="h" name="h" title="Height" type="text" size="4" maxlength="5" value="<?=
        ($this->human->getHeight() > 0) ? $this->human->getHeight() : '';
    ?>" />meters</nobr>
    &nbsp;
    <nobr><label for="a">Age:</label>
    <input id="a" name="a" title="Age" type="text" size="4" maxlength="5" value="<?=
        ($this->human->getAge() > 0) ? $this->human->getAge() : '';
    ?>" />years</nobr>
    &nbsp;
    <nobr><label>Sex:</label>
<?php
    $checked = ' checked="checked"';
    $checkM = (isset($_GET['x']) && $_GET['x'] == 'm') ? $checked : '';
    $checkF = (isset($_GET['x']) && $_GET['x'] == 'f') ? $checked : '';
?>
    <input type="radio" title="male" name="x" value="m" <?= $checkM; ?>>male
    <input type="radio" title="female" name="x" value="f"  <?= $checkF; ?>>female
    </nobr>
    <br />
    <br />
    <div style="text-align:right;">
        <em>Options:</em>
        &nbsp;
        <label>Range:</label>
        <input id="s" name="s" title="Chart start" size="2" maxlength="3" value="<?= $this->startMass; ?>" />-<input
                id="e" name="e" title="Chart end" size="2" maxlength="3" value="<?= $this->endMass; ?>" />kg
        &nbsp;
        <label for="i">Increment:</label>
        <input id="i" name="i" title="Increment" size="2" maxlength="6" value="<?= $this->increment; ?>" />kg
    </div>
</form>
