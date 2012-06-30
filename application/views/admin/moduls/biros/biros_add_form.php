<h2>Add a Biro User</h2>
<?=form_open('admin/biros/add')?>
<fieldset>
	<legend><span>*</span>Required Field</legend>
	<ul>
		<li>
			<label>First Name<span>*</span></label>
			<?=form_input('biroFirstName', set_value('biroFirstName'))?>
			<?=form_error('biroFirstName')?>
		</li>
		<li>
			<label>Last Name<span>*</span></label>
			<?=form_input('biroLastName', set_value('biroLastName'))?>
			<?=form_error('biroLastName')?>
		</li>
		<li>
			<label>Username<span>*</span></label>
			<?=form_input('userName', set_value('userName'))?>
			<?=form_error('userName')?>
		</li>
                <li>
			<label>Password<span>*</span></label>
			<?=form_input('userPassword', set_value('userPassword'))?>
			<?=form_error('userPassword')?>
		</li>
                <li>
			<label>Email</label>
			<?=form_input('biroEmail', set_value('biroEmail'))?>
			<?=form_error('biroEmail')?>
		</li>
                <li>
			<label>Status</label>
			<?=form_dropdown('biroStatus', array('active'=>'Active', 'inactive'=>'inactive'))?>
			<?=form_error('biroStatus')?>
		</li>
		<li>
			<?=form_submit('', 'Add Biro User')?>
		</li>
	</ul>
</fieldset>
<?=form_close()?>
