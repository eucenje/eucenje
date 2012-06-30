<div class="row">
    <div class="twelve columns">
<h5>Измени Администратор</h5>
<?=form_open('admin/admins/edit/'. $admin->adminId)?>
<fieldset>
	<legend><span>*</span>Задолжителни полиња</legend>
	<ul>
		<li>
			<label>Име<span>*</span></label>
			<?=form_input('adminFirstName', set_value('adminFirstName', $admin->adminFirstName))?>
			<?=form_error('adminFirstName')?>
		</li>
		<li>
			<label>Презиме<span>*</span></label>
			<?=form_input('adminLastName', set_value('adminLastName', $admin->adminLastName))?>
			<?=form_error('adminLastName')?>
		</li>
		<li>
			<label>Корисничко име<span>*</span></label>
			<?=form_input('userName', set_value('userName', $admin->userName))?>
			<?=form_error('userName')?>
		</li>
                <li>
			<label>Лозинка<span>*</span></label>
			<?=form_input('userPassword', set_value('userPassword'))?>
			<?=form_error('userPassword')?>
		</li>
                <li>
			<label>Емаил</label>
			<?=form_input('adminEmail', set_value('adminEmail', $admin->adminEmail))?>
			<?=form_error('adminEmail')?>
		</li>
                <li>
			<label>Статус</label>
			<?=form_dropdown('adminStatus', array('active'=>'Active', 'inactive'=>'inactive'), set_value('adminStatus', $admin->adminStatus))?>
			<?=form_error('adminStatus')?>
		</li>
		<li>
			<?=form_submit('', 'Снимај ги промените')?>
		</li>
	</ul>
</fieldset>
<?=form_close()?>
</div></div>    