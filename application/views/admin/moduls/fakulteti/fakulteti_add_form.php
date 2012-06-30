<div class="row">
    <div class="twelve columns">
<h5>Додади Факултет</h5>
<?=form_open('admin/fakulteti/add')?>
<fieldset>
	<legend><span>*</span>Задолжителни полиња</legend>
	<ul>
		<li>
			<label>Име<span>*</span></label>
			<?=form_input('fakultetName', set_value('fakultetName'))?>
			<?=form_error('fakultetName')?>
		</li>
		<li>
			<label>Вид на студии<span>*</span></label>
                        <?=form_dropdown('fakultetType', array('diplomski'=>'Дипломски студии', 'postdiplomski'=>'Постдипломски студии'))?>
			<?=form_error('fakultetType')?>
		</li>
		<li>
			<label>Години на студирање<span>*</span></label>
			<?=form_input('fakultetYears', set_value('fakultetYears'))?>
			<?=form_error('fakultetYears')?>
		</li>
                <li>
			<label>Статус</label>
			<?=form_dropdown('fakultetStatus', array('active'=>'Активен', 'inactive'=>'Не Активен'))?>
			<?=form_error('fakultetStatus')?>
		</li>
		<li>
			<?=form_submit(array('value'=> 'Додади Факулктет', 'class'=>'button green small'))?>
		</li>
	</ul>
</fieldset>
<?=form_close()?>
</div></div>    