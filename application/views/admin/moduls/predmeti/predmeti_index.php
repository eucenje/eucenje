<div class="row">
    <div class="twelve columns">
        <div class="panel">
            <h5>Предмети</h5>
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
            <a href="<?=base_url()?>admin/predmeti/add" class="button small green">Додади предмет</a><br/><br/>

            <table id="predmeti-table" class="dataTable">
                <thead>
                    <tr>
                        <th>Назив</th>
                        <th>Статус</th>
                        <th>Алатки</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        var oTable = $('#predmeti-table').dataTable( {
            "bProcessing": true,
            "sAjaxSource": "<?= base_url() ?>admin/predmeti/index?json",
                    
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