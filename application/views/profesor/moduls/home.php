<div class="row">
    <div class="eight columns">
        <div class="panel">
            <h4>Добредојде професоре,</h4><br>
            <h5>Студенти</h5>
            <hr/>
            <a style="margin-left: 20px;" href="<?= base_url() ?>profesor/settings/edit_personal_info"><img src="<?= base_url() ?>images/students.png" alt="Промена на лични податоци"/></a>
            <hr/>
            <h5>Подесувања</h5>
            <hr/>
            <a style="margin-left: 20px;" href="<?= base_url() ?>profesor/settings/edit_personal_info"><img src="<?= base_url() ?>images/user.png" alt="Промена на лични податоци"/></a>
            <a style="margin-left: 30px;" href="<?= base_url() ?>profesor/settings/edit_account_info"><img src="<?= base_url() ?>images/process.png" alt="Промена на информации за најава"/></a>
            <hr/>
        </div>
    </div>
    <div class="four columns">
        <div class="panel">
            <h5>Предмети</h5>
            <hr/>
            <? if (empty($predmeti)) echo 'Сеуште немате доделено предмети.' ?>
            <ul class="disc">
                <? foreach ($predmeti as $id => $predmet): ?>
                    <li><a href="<?= base_url() ?>profesor/predmeti/overview/<?= $id ?>"><?= $predmet ?></a></li>
                <? endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="four columns">
        <div class="panel">
            <p>Во иднина, би сакале да додадеме повеќе опции во овој панел, како на пример:</p>  
            <ul class="disc">
                <li>Приватни пораки</li>
                <li>Директен Контакт до ИТ службата</li>
                <li>Отценки за студентите</li>
                <li>RSS feed</li>
                <li>Емаил зачленување (email subscription)</li>
            </ul>
            <p>Како и многу други опции како што и другите софтвери за електронско учење поседуваат.<br/>
            Со секое додавање на нов модул секој од професорите ќе биде известен и исто така ќе добие документација (user guide) како да го користи истиот.
            </p>
        </div>
    </div>
</div>
