<div class="row">
    <div class="twelve columns"style="margin-top: 30px" >
        <div class="panel">
            <fieldset>
                <legend>Лични податоци</legend>
                <?= form_open(base_url() . 'profesor/settings/edit_personal_info') ?>
                <label>Име</label>
                <?= form_input('profesorFirstName', set_value('profesorFirstName', $profesor->profesorFirstName)) ?><br/>
                <label>Презиме</label>
                <?= form_input('profesorLastName', set_value('profesorLastName', $profesor->profesorLastName)) ?><br/>
                <label>емаил</label>
                <?= form_input('profesorEmail', set_value('profesorEmail', $profesor->profesorEmail)) ?><br/>
                <?= form_submit('', 'Зачувај ги промените') ?>
                <?= form_close() ?>
            </fieldset>
        </div>
    </div>
</div>