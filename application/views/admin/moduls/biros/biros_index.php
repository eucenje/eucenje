<a href='<?=base_url()?>admin/biros/add'>Add a Biro User</a>

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

<table border="1">
	<tr>
		<td>First Name</td>
		<td>Last Name</td>
		<td>Username</td>
		<td>Email</td>
                <td>Status</td>
		<td>Actions</td>
	</tr>
	<?if(isset($biros) && is_array($biros) && count($biros)>0):?>
		<?foreach($biros as $biro):?>
			<tr>
				<td><?=$biro->biroFirstName?></td>
				<td><?=$biro->biroLastName?></td>
				<td><?=$biro->userName?></td>
                                <td><?=$biro->biroEmail?></td>
                                <td><?=$biro->biroStatus?></td>
				<td>
                                        <a href='<?=base_url()?>admin/biros/edit/<?=$biro->biroId?>'>Edit</a> |
                                        <a href='<?=base_url()?>admin/biros/delete/<?=$biro->biroId?>'>Delete</a>
                                </td>
			</tr>
		<?endforeach?>
	<?else:?>
		<tr>
			<td colspan="6">There are currently no biros.</td>
		</tr>
	<?endif?>
</table>

<?if(isset($pagination)):?>
	<div class='pagination'>
		<?=$pagination?>
	</div>
<?endif?>
