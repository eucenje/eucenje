<?
//<a href='<?=base_url()admin/admins/add'>Add a Administrator</a>
?>
<?if($this->session->flashdata('flashError')):?>
<div class='flashError'>
	Error! <?=$this->session->flashdata('flashError')?>
</div>
<?endif?>

<?if($this->session->flashdata('flashConfirm')):?>
<div class='flashConfirm'>
	Success! <?=$this->session->flashdata('flashConfirm')?>
</div>
<?endif?>

We are here....
<?php
	$this->load->view('admin/footer');
?>
