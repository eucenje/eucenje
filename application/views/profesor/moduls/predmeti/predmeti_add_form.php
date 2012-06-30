<div class="row">
    <div class="twelve columns">
<h5>Додади Предмет</h5>
<?=form_open('profesor/predmeti/add')?>
<fieldset>
	<legend><span>*</span>Задолжителни полиња</legend>
	<ul>
		<li>
			<label>Име<span>*</span></label>
			<?=form_input('predmetName', set_value('predmetName'))?>
			<?=form_error('predmetName')?>
		</li>
		<li>
			<label>Факултет<span>*</span></label>
                        <?=form_dropdown('predmetFakultetId', $fakulteti)?>
			<?=form_error('predmetFakultetId')?>
		</li>
                <input type="hidden" name="predmetProfesorId" value="<?=$id?>"/>
                <li>
			<label>Статус</label>
			<?=form_dropdown('predmetStatus', array('active'=>'Активен', 'inactive'=>'Не Активен'))?>
			<?=form_error('predmetStatus')?>
		</li>
		<li>
			<?=form_submit(array('value'=> 'Додади Предмет', 'class'=>'button green small'))?>
		</li>
	</ul>
</fieldset>
<?=form_close()?>
</div></div>    