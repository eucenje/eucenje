<div class="row">
    <div class="eight columns">
        <div class="panel">
            <p>Six columns</p>
        </div>
    </div>
    <div class="four columns">
        <div class="panel">
            <h6>Мои Предмети</h6><br/>
            <? if(empty($predmeti)) echo 'Сеуште немате доделено предмети.' ?>
            <ul class="disc">
            <? foreach($predmeti as $id => $predmet):?>
                 <li><a href="<?=base_url()?>profesor/predmeti/overview/<?=$id?>"><?=$predmet?></a></li>
           <? endforeach; ?>
            </ul>
        </div>
        
    </div>
</div>
