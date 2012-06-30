<div class="row">
    <div class="twelve columns"style="margin-top: 30px" >
        <div class="panel">
            <fieldset>
                <legend>Лични податоци</legend>
                <?= form_open(base_url() . 'admin/settings/edit_personal_info') ?>
                <label>Име</label>
                <?= form_input('adminFirstName', set_value('adminFirstName', $admin->adminFirstName)) ?><br/>
                <label>Презиме</label>
                <?= form_input('adminLastName', set_value('adminLastName', $admin->adminLastName)) ?><br/>
                <label>емаил</label>
                <?= form_input('adminEmail', set_value('adminEmail', $admin->adminEmail)) ?><br/>
                <?= form_submit('', 'Зачувај ги промените') ?>
                <?= form_close() ?>
            </fieldset>
        </div>
    </div>
</div>