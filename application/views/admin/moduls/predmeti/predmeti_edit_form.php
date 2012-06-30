<div class="row">
    <div class="twelve columns">
<h5>Додади Факултет</h5>
<?=form_open('admin/predmeti/edit/'.$predmet->predmetId)?>
<fieldset>
	<legend><span>*</span>Задолжителни полиња</legend>
	<ul>
		<li>
			<label>Име<span>*</span></label>
			<?=form_input('predmetName', set_value('predmetName', $predmet->predmetName))?>
			<?=form_error('predmetName')?>
		</li>
		<li>
			<label>Вид на студии<span>*</span></label>
                        <?=form_dropdown('predmetType', array('diplomski'=>'Дипломски студии', 'postdiplomski'=>'Постдипломски студии'), set_value('predmetType', $predmet->predmetType))?>
			<?=form_error('predmetType')?>
		</li>
		<li>
			<label>Години на студирање<span>*</span></label>
			<?=form_input('predmetYears', set_value('predmetYears', $predmet->predmetYears))?>
			<?=form_error('predmetYears')?>
		</li>
                <li>
			<label>Статус</label>
			<?=form_dropdown('predmetStatus', array('active'=>'Активен', 'inactive'=>'Не Активен'), set_value('predmetStatus', $predmet->predmetStatus))?>
			<?=form_error('predmetStatus')?>
		</li>
		<li>
			<?=form_submit(array('value'=> 'Додади Факулктет', 'class'=>'button green small'))?>
		</li>
	</ul>
</fieldset>
<?=form_close()?>
</div></div>    