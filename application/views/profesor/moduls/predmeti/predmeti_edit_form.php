<div class="row">
    <div class="twelve columns">
<h5>Измени Предмет</h5>
<?=form_open('profesor/predmeti/edit/'.$predmet->predmetId)?>
<fieldset>
	<legend><span>*</span>Задолжителни полиња</legend>
	<ul>
		<li>
			<label>Име<span>*</span></label>
			<?=form_input('predmetName', set_value('predmetName', $predmet->predmetName))?>
			<?=form_error('predmetName')?>
		</li>
		
                <li>
			<?=form_submit(array('value'=> 'Измени Предмет', 'class'=>'button green small'))?>
		</li>
	</ul>
</fieldset>
<?=form_close()?>
</div></div>    