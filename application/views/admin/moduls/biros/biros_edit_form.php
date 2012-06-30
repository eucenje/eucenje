<h2>Edit a Biro User</h2>
<?=form_open('admin/biros/edit/'. $biro->biroId)?>
<fieldset>
	<legend><span>*</span>Required Field</legend>
	<ul>
		<li>
			<label>First Name<span>*</span></label>
			<?=form_input('biroFirstName', set_value('biroFirstName', $biro->biroFirstName))?>
			<?=form_error('biroFirstName')?>
		</li>
		<li>
			<label>Last Name<span>*</span></label>
			<?=form_input('biroLastName', set_value('biroLastName', $biro->biroLastName))?>
			<?=form_error('biroLastName')?>
		</li>
		<li>
			<label>Username<span>*</span></label>
			<?=form_input('userName', set_value('userName', $biro->userName))?>
			<?=form_error('userName')?>
		</li>
                <li>
			<label>Password<span>*</span></label>
			<?=form_input('userPassword', set_value('userPassword'))?>
			<?=form_error('userPassword')?>
		</li>
                <li>
			<label>Email</label>
			<?=form_input('biroEmail', set_value('biroEmail', $biro->biroEmail))?>
			<?=form_error('biroEmail')?>
		</li>
                <li>
			<label>Status</label>
			<?=form_dropdown('biroStatus', array('active'=>'Active', 'inactive'=>'inactive'), set_value('biroStatus', $biro->biroStatus))?>
			<?=form_error('biroStatus')?>
		</li>
		<li>
			<?=form_submit('', 'Save Changes')?>
		</li>
	</ul>
</fieldset>
<?=form_close()?>
