<form class="themeswitcher_select_form" method="post">
    <label for="themeswitcher_<?=$this->run()?>"><?=$this->text('label_theme')?></label>
    <select id="themeswitcher_<?=$this->run()?>" name="themeswitcher_select">
<?php foreach ($this->themes as $theme):?>
        <option value="<?=$this->escape($theme->name)?>" <?=$this->escape($theme->selected)?>><?=$this->escape($theme->name)?></option>
<?php endforeach?>
    </select>
    <button><?=$this->text('label_activate')?></button>
</form>
