<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * @var Form $this
 */

?>
<div class="collapse show" id="options">
    <form>
        <div class="row mx-5 px-2">
            <div class="col">
                <label for="h">Height:</label>
                <input id="h" name="h" title="Height" type="text" size="4" maxlength="5" value="<?=
                    $this->data['height']
                ?>" />meters
            </div>
            <div class="col">
                <label for="a">Age:</label>
                <input id="a" name="a" title="Age" type="text" size="4" maxlength="5" value="<?=
                    $this->data['age']
                ?>" />years
            </div>
            <div class="col">
                <label>Sex:</label>
                <input type="radio" title="male" name="x" value="m" <?=
                    $this->data['checkM']
                ?>>male
                <input type="radio" title="female" name="x" value="f" <?=
                    $this->data['checkF']
                ?>>female
            </div>
        </div>
        <div class="row mx-5 px-2 bg-light">
            <div class="col">
                <em>Options:</em>
            </div>
            <div class="col">
                <label>Range:</label>
                <input id="s" name="s" title="Table start" size="4" maxlength="5" value="<?=
                    $this->data['startMass']
                ?>" />-<input id="e" name="e" title="Table end" size="4" maxlength="5" value="<?=
                    $this->data['endMass']
                ?>" />kg
            </div>
            <div class="col">
                <label for="i">Increment:</label>
                <input id="i" name="i" title="Increment" size="3" maxlength="6" value="<?=
                    $this->data['increment']
                ?>" />kg
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
