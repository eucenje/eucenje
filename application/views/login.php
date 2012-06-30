<pre>
<?=print_r($this->session->userdata);?>
</pre>
<?=form_open(base_url() . 'login')?>

<?if($this->session->flashdata('flashError')):?>
<div class='flashError'>
	<?=$this->session->flashdata('flashError')?>
</div>
<?endif?>

<fieldset>
	<legend>Login Form</legend>
	<ul>
		<li>
			<label>Username</label>
			<?=form_input('userName', set_value('userName'))?>
			<?=form_error('userName')?>
		</li>
		<li>
			<label>Password</label>
			<?=form_password('userPassword')?>
			<?=form_error('userPassword')?>
		</li>
		<li>
			<?=form_submit('', 'Login')?>
		</li>
	</ul>
</fieldset>
<?=form_close()?>
