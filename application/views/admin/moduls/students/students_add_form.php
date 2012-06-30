<div class="row">
    <div class="twelve columns">
<h5>Додади Студент</h5>
<?=form_open('admin/students/add')?>
<fieldset>
	<legend><span>*</span>Задолжителни полиња</legend>
	<ul>
		<li>
			<label>Име<span>*</span></label>
			<?=form_input('studentFirstName', set_value('studentFirstName'))?>
			<?=form_error('studentFirstName')?>
		</li>
		<li>
			<label>Презиме<span>*</span></label>
			<?=form_input('studentLastName', set_value('studentLastName'))?>
			<?=form_error('studentLastName')?>
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
			<?=form_input('studentEmail', set_value('studentEmail'))?>
			<?=form_error('studentEmail')?>
		</li>
                <li>
			<label>Статус</label>
			<?=form_dropdown('studentStatus', array('active'=>'Активен', 'inactive'=>'Не Активен'))?>
			<?=form_error('studentStatus')?>
		</li>
		<li>
			<?=form_submit(array('value'=> 'Додади Студент', 'class'=>'button green small'))?>
		</li>
	</ul>
</fieldset>
<?=form_close()?>
</div></div>    