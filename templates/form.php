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
                $this->data['height']
            ?>" /> meters
        </div>
        <div class="col nobr">
            <label for="a">Age:</label>
            <br />
            <input id="a" name="a" title="Age" type="text" size="4" maxlength="5" value="<?=
                $this->data['age']
            ?>" /> years
        </div>
        <div class="col nobr">
            <label for="x">Sex:</label>
            <br />
            <input type="radio" title="male" name="x" id="x" value="m" <?=
                $this->data['checkM']
            ?>> Male
            <br />
            <input type="radio" title="female" name="x" id="x" value="f" <?=
                $this->data['checkF']
            ?>> Female
        </div>
    </div>
    <div class="collapse show" id="options">
        <div class="row mx-5 mt-3 px-2 bg-light border">
            <div class="col nobr">
                <label for="s">Range:</label><label for="e"></label>
                <br />
                <input id="s" name="s" title="Table start" size="4" maxlength="5" value="<?=
                    $this->data['startMass']
                ?>" />-<input id="e" name="e" title="Table end" size="4" maxlength="5" value="<?=
                    $this->data['endMass']
                ?>" />kg
            </div>
            <div class="col nobr">
                <label for="i">Increment:</label>
                <br />
                <input id="i" name="i" title="Increment" size="3" maxlength="6" value="<?=
                    $this->data['increment']
                ?>" />kg
            </div>
        </div>
    </div>
    <div class="righty">
        <a data-toggle="collapse" href="#options" aria-expanded="false" aria-controls="options">Toggle Options</a>
    </div>
</form>
