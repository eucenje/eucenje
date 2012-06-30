<h2>Edit User "<?=$user->userName?>"</h2>
<?=form_open('admin/users/edit/' . $user->userId)?>
<fieldset>
	<legend><span>*</span>Required Field</legend>
	<ul>
		<li>
			<label>Username<span>*</span></label>
			<?=form_input('userName', set_value('userName', $user->userName))?>
			<?=form_error('userName')?>
		</li>
		<li>
			<label>Set New Password</label>
			<?=form_input('userPassword')?>
			<?=form_error('userPassword')?>
		</li>
		<li>
			<label>Type<span>*</span></label>
			<?=form_dropdown('userType', array('admin' => 'Admin User', 'biro'=> 'Biro'), set_value('userType', $user->userType))?>
			<?=form_error('userType')?>
		</li>
		<li>
			<label>Status<span>*</span></label>
			<?=form_dropdown('userStatus', array('active' => 'Can log in', 'inactive' => 'Cannot log in'), set_value('userStatus', $user->userStatus))?>
			<?=form_error('userStatus')?>
		</li>
		<li>
			<?=form_submit('', 'Save Change')?>
		</li>
	</ul>
</fieldset>
<?=form_close()?>
