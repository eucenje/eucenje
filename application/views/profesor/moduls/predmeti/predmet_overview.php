<div class="row">
    <div class="eight columns">
        <div class="panel">
            <h5><?= $predmet->predmetName ?></h5>
            <hr/>
            <p>Вкупно студенти на предметот: 12</p>
        </div>
    </div>
    <div class="four columns">
        <div class="panel">
            <h6>Материјали</h6>
            <hr/>
             <ul class="disc">
                 <li><a href="">asdasdasd</a></li>
             </ul>
            <a href="#" id="buttonMaterijal" class="small button blue" style="padding: 7px !important;">Додади материјал</a><br/><br/>
            <h6>Видео предавања</h6>
            <hr/>
            
             <ul class="disc">
                 <li><a href="">Neko</a></li>
             </ul>
            <a href="" class="small button blue" style="padding: 7px !important;">Додади видео предавање</a><br/><br/>
            <h6><a href="#">Форум</a></h6>
            <hr/>
            <h6>Задачи</h6>
            <hr/>
            <p>Сеуште нема закачено задачи.</p>
            <a href="" class="small button blue" style="padding: 7px !important;">Додади Задача</a><br/><br/>
        </div>
    </div>
</div>

<div id="dodadiMaterijal" class="reveal-modal">
  <h2>Додади Материјал</h2>
  <p>Можете да додадете материјал во било каква форма (doc, ppt, odt, jpg, pdf... итн).</p>
  <?=form_open('profesor/predmeti/materijal/add')?>
    <?=form_upload()?>
    <?=form_submit('','Прикачи')?>
  <?=form_close()?>
  <a class="close-reveal-modal">&#215;</a>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#buttonMaterijal').click(function() {
      $('#dodadiMaterijal').reveal();
    });
  });
</script>