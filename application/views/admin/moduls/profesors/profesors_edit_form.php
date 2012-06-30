<div class="row">
    <div class="twelve columns">
<h5>Измени Професор</h5>
<?=form_open('admin/profesors/edit/'. $profesor->profesorId)?>
<fieldset>
	<legend><span>*</span>Задолжителни полиња</legend>
	<ul>
		<li>
			<label>Име<span>*</span></label>
			<?=form_input('profesorFirstName', set_value('profesorFirstName', $profesor->profesorFirstName))?>
			<?=form_error('profesorFirstName')?>
		</li>
		<li>
			<label>Презиме<span>*</span></label>
			<?=form_input('profesorLastName', set_value('profesorLastName', $profesor->profesorLastName))?>
			<?=form_error('profesorLastName')?>
		</li>
		<li>
			<label>Корисничко име<span>*</span></label>
			<?=form_input('userName', set_value('userName', $profesor->userName))?>
			<?=form_error('userName')?>
		</li>
                <li>
			<label>Лозинка<span>*</span></label>
			<?=form_input('userPassword', set_value('userPassword'))?>
			<?=form_error('userPassword')?>
		</li>
                <li>
			<label>Емаил</label>
			<?=form_input('profesorEmail', set_value('profesorEmail', $profesor->profesorEmail))?>
			<?=form_error('profesorEmail')?>
		</li>
                <li>
			<label>Статус</label>
			<?=form_dropdown('profesorStatus', array('active'=>'Active', 'inactive'=>'inactive'), set_value('profesorStatus', $profesor->profesorStatus))?>
			<?=form_error('profesorStatus')?>
		</li>
		<li>
			<?=form_submit('', 'Снимај ги промените')?>
		</li>
	</ul>
</fieldset>
<?=form_close()?>
</div></div>    