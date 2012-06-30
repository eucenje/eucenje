<div class="row">
    <div class="twelve columns"style="margin-top: 30px" >
        <div class="panel">
            <fieldset>
                <legend>Информации за најава на системот</legend>
                <?= form_open(base_url() . 'admin/settings/edit_account_info') ?>
                <label>Корисничко име</label>
                <?= form_input('userName', set_value('userName', $user->userName)) ?><br/>
                <label>Лозинка</label>
                <?= form_input('userPassword') ?><br/>
                <?= form_submit('', 'Зачувај ги промените') ?>
                <?= form_close() ?>
            </fieldset>
        </div>
    </div>
</div>