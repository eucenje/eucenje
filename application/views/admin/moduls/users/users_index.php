<div class="row">
    <div class="twelve columns">
        <div class="panel">
            <dl class="nice contained tabs">
                <dd><a href="#nice1" class="active">Администратори</a></dd>
                <dd><a href="#nice2">Професори</a></dd>
                <dd><a href="#nice3">Студенти</a></dd>
            </dl>

            <ul class="nice tabs-content contained">
                <li class="active" id="nice1Tab">
                    <? if ($this->session->flashdata('flashError')): ?>

                        <div class="alert-box error">
                            <span><?= $this->session->flashdata('flashError') ?></span>
                            <a href="" class="close">&times;</a>
                        </div>

                    <? endif ?>
                    <? if ($this->session->flashdata('flashConfirm')): ?>

                        <div class="alert-box success">
                            <span><?= $this->session->flashdata('flashConfirm') ?></span>
                            <a href="" class="close">&times;</a>
                        </div>

                    <? endif ?>
                    <br/>
                    <a href="<?= base_url() ?>admin/admins/add" class="button small green">Додади Администратор</a><br/><br/>

                    <table id="admin-table" class="dataTable">
                        <thead>
                            <tr>
                                <th>Име</th>
                                <th>Презиме</th>
                                <th>Емаил</th>
                                <th>Статус</th>
                                <th>Алатки</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </li>
                <li id="nice2Tab">
      <? if ($this->session->flashdata('flashError')): ?>

                        <div class="alert-box error">
                            <span><?= $this->session->flashdata('flashError') ?></span>
                            <a href="" class="close">&times;</a>
                        </div>

                    <? endif ?>
                    <? if ($this->session->flashdata('flashConfirm')): ?>

                        <div class="alert-box success">
                            <span><?= $this->session->flashdata('flashConfirm') ?></span>
                            <a href="" class="close">&times;</a>
                        </div>

                    <? endif ?>
                    <br/>
                    <a href="<?= base_url() ?>admin/profesors/add" class="button small green">Додади Професор</a><br/><br/>

                    <table id="profesors-table" class="dataTable">
                        <thead>
                            <tr>
                                <th>Име</th>
                                <th>Презиме</th>
                                <th>Емаил</th>
                                <th>Статус</th>
                                <th>Алатки</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>


                </li>
                <li id="nice3Tab">
                    <div class="alert-box">
                        <b>Забелешка!</b> <span>Пред додавање нов Студент потребно е да постои факултет каде тој е запишан!</span>
                        <a href="" class="close">&times;</a>
                    </div>
                      <? if ($this->session->flashdata('flashError')): ?>

                        <div class="alert-box error">
                            <span><?= $this->session->flashdata('flashError') ?></span>
                            <a href="" class="close">&times;</a>
                        </div>

                    <? endif ?>
                    <? if ($this->session->flashdata('flashConfirm')): ?>

                        <div class="alert-box success">
                            <span><?= $this->session->flashdata('flashConfirm') ?></span>
                            <a href="" class="close">&times;</a>
                        </div>

                    <? endif ?>
                    <br/>
                    <a href="<?= base_url() ?>admin/students/add" class="button small green">Додади Студент</a><br/><br/>

                    <table id="students-table" class="dataTable">
                        <thead>
                            <tr>
                                <th>Име</th>
                                <th>Презиме</th>
                                <th>Емаил</th>
                                <th>Статус</th>
                                <th>Алатки</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </li>
                

            </ul>

        </div>
    </div>
</div>


<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        var oTable = $('#admin-table').dataTable( {
            "bProcessing": true,
            "sAjaxSource": "<?= base_url() ?>admin/admins/index?json",
                    
            "fnDrawCallback": function(){
                $('.dataTable tbody tr').hover(function() {
                    $(this).css('cursor', 'pointer');
                }, function() {
                    $(this).css('cursor', 'auto');
                });
            },
            "oLanguage": {
                "sLengthMenu": "Покажи _MENU_ редови по страна",
                "sZeroRecords": "Ништо не е пронајдено!",
                "sInfo": "Покажува _START_ до _END_ од _TOTAL_ вкупно редови",
                "sInfoEmpty": "Покажува 0 до 0 од 0 редови",
                "sInfoFiltered": "(филтрирано од _MAX_ вкупно редови)"
            }
                    
                    
        } );
         var oTable = $('#profesors-table').dataTable( {
            "bProcessing": true,
            "sAjaxSource": "<?= base_url() ?>admin/profesors/index?json",
                    
            "fnDrawCallback": function(){
                $('.dataTable tbody tr').hover(function() {
                    $(this).css('cursor', 'pointer');
                }, function() {
                    $(this).css('cursor', 'auto');
                });
            },
            "oLanguage": {
                "sLengthMenu": "Покажи _MENU_ редови по страна",
                "sZeroRecords": "Ништо не е пронајдено!",
                "sInfo": "Покажува _START_ до _END_ од _TOTAL_ вкупно редови",
                "sInfoEmpty": "Покажува 0 до 0 од 0 редови",
                "sInfoFiltered": "(филтрирано од _MAX_ вкупно редови)"
            }
                    
                    
        } );
        var oTable = $('#students-table').dataTable( {
            "bProcessing": true,
            "sAjaxSource": "<?= base_url() ?>admin/students/index?json",
                    
            "fnDrawCallback": function(){
                $('.dataTable tbody tr').hover(function() {
                    $(this).css('cursor', 'pointer');
                }, function() {
                    $(this).css('cursor', 'auto');
                });
            },
            "oLanguage": {
                "sLengthMenu": "Покажи _MENU_ редови по страна",
                "sZeroRecords": "Ништо не е пронајдено!",
                "sInfo": "Покажува _START_ до _END_ од _TOTAL_ вкупно редови",
                "sInfoEmpty": "Покажува 0 до 0 од 0 редови",
                "sInfoFiltered": "(филтрирано од _MAX_ вкупно редови)"
            }
                    
                    
        } );
    } );
</script>