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

<table border="1" id="test" class="table">
    <thead>
        
	<tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Username</th>
		<th>Email</th>
                <th>Status</th>
		<th>Actions</th>
	</tr>
    </thead>
    <tbody>
	<?if(isset($admins) && is_array($admins) && count($admins)>0):?>
		<?foreach($admins as $admin):?>
			<tr>
				<td><?=$admin->adminFirstName?></td>
				<td><?=$admin->adminLastName?></td>
				<td><?=$admin->userName?></td>
                                <td><?=$admin->adminEmail?></td>
                                <td><?=$admin->adminStatus?></td>
				<td>
                                        <a href='<?=base_url()?>admin/admins/edit/<?=$admin->adminId?>'>Edit</a> |
                                        <a href='<?=base_url()?>admin/admins/delete/<?=$admin->adminId?>'>Delete</a>
                                </td>
			</tr>
		<?endforeach?>
	<?else:?>
		<tr>
			<td colspan="6">There are currently no admins.</td>
		</tr>
	<?endif?>
                </tbody>
</table>

<?if(isset($pagination)):?>
	<div class='pagination'>
		<?=$pagination?>
	</div>
<?endif?>

<?php
$data['footer']= <<<EOD

$('#test').dataTable();

EOD;


$this->load->view('admin/footer', $data);

?>

