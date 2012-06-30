<div class="row">
    <div class="twelve columns">
<h5>Додади Предмет</h5>
<?=form_open('admin/predmeti/add')?>
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
		<li>
			<label>Професор<span>*</span></label>
			 <?=form_dropdown('predmetProfesorId', $profesors)?>
			<?=form_error('predmetProfesorId')?>
		</li>
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