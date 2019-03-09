<?php
declare(strict_types = 1);

namespace Attogram\Body;

?>
<form>
    <input type="submit" value="          Update Chart          " />
    &nbsp;
    <label for="h">Height:</label>
    <input id="h" name="h" title="Height" type="text" size="4" maxlength="5" value="<?=
        ($this->human->height > 0) ? $this->human->height : '';
    ?>" />meters
    &nbsp;
    <label for="a">Age:</label>
    <input id="a" name="a" title="Age" type="text" size="4" maxlength="5" value="<?=
        ($this->human->age > 0) ? $this->human->age : '';
    ?>" />years
    &nbsp;
    <label>Sex:</label>
<?php
    $checked = ' checked="checked"';
    $checkM = (isset($_GET['x']) && $_GET['x'] == 'm') ? $checked : '';
    $checkF = (isset($_GET['x']) && $_GET['x'] == 'f') ? $checked : '';
    if (!$checkM && !$checkF) {
        $checkM =  $checked;
    }
?>
    <input type="radio" title="male" name="x" value="m" <?= $checkM; ?>>male
    <input type="radio" title="female" name="x" value="f"  <?= $checkF; ?>>female
    <br />
    <br />
    <em>Options:</em>
    &nbsp;
    <label>Range:</label>
    <input id="s" name="s" title="Chart start" size="2" maxlength="3" value="<?= $this->startMass; ?>" />-<input
        id="e" name="e" title="Chart end" size="2" maxlength="3" value="<?= $this->endMass; ?>" />kg
    &nbsp;
    <label for="i">Increment:</label>
    <input id="i" name="i" title="Increment" size="2" maxlength="6" value="<?= $this->increment; ?>" />kg
</form>
