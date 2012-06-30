<div class="row">
    <div class="twelve columns">
<h5>Додади Администратор</h5>
<?=form_open('admin/admins/add')?>
<fieldset>
	<legend><span>*</span>Задолжителни полиња</legend>
	<ul>
		<li>
			<label>Име<span>*</span></label>
			<?=form_input('adminFirstName', set_value('adminFirstName'))?>
			<?=form_error('adminFirstName')?>
		</li>
		<li>
			<label>Презиме<span>*</span></label>
			<?=form_input('adminLastName', set_value('adminLastName'))?>
			<?=form_error('adminLastName')?>
		</li>
		<li>
			<label>Корисничко име<span>*</span></label>
			<?=form_input('userName', set_value('userName'))?>
			<?=form_error('userName')?>
		</li>
                <li>
			<label>Лозинка<span>*</span></label>
			<?=form_input('userPassword', set_value('userPassword'))?>
			<?=form_error('userPassword')?>
		</li>
                <li>
			<label>Емаил</label>
			<?=form_input('adminEmail', set_value('adminEmail'))?>
			<?=form_error('adminEmail')?>
		</li>
                <li>
			<label>Статус</label>
			<?=form_dropdown('adminStatus', array('active'=>'Активен', 'inactive'=>'Не Активен'))?>
			<?=form_error('adminStatus')?>
		</li>
		<li>
			<?=form_submit(array('value'=> 'Додади Администратор', 'class'=>'button green small'))?>
		</li>
	</ul>
</fieldset>
<?=form_close()?>
</div></div>    