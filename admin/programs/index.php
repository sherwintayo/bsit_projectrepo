<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Programs</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Add New Program</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="30%">
					<col width="15%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Name</th>
						<th>Description</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT * from `program_list`order by `name` asc ");
						while($row = $qry->fetch_assoc()):
						
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo ucwords($row['name']) ?></td>
							<td class="truncate-1"><?php echo $row['description'] ?></td>
							<td class="text-center">
                                <?php
                                    switch($row['status']){
                                        case '1':
                                            echo "<span class='badge badge-success badge-pill'>Active</span>";
                                            break;
                                        case '0':
                                            echo "<span class='badge badge-secondary badge-pill'>Inactive</span>";
                                            break;
                                    }
                                ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
        $('#create_new').click(function(){
			uni_modal("Program Details","programs/manage_program.php")
		})
        $('.edit_data').click(function(){
			uni_modal("Program Details","programs/manage_program.php?id="+$(this).attr('data-id'))
		})
		$('.delete_data').click(function(){
        var id = $(this).attr('data-id'); // Get the ID from data-id attribute
        _conf("Are you sure to delete this Program permanently?","delete_program",[id]); // Confirm deletion
    })
		$('.view_data').click(function(){
			uni_modal("Program Details","programs/view_program.php?id="+$(this).attr('data-id'))
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
	})
	
	function delete_program(id){
    start_loader();
    $.ajax({
        url: _base_url_ + "classes/Master.php?f=delete_program",
        method: "POST",
        data: { id: id },
        dataType: "json",
        error: function(err){
            console.log(err);
            alert_toast("An error occurred.", 'error');
            end_loader();
        },
        success: function(resp){
            if(resp.status == 'success'){
                alert_toast("Program deleted successfully.", 'success');
                location.reload(); // Reload the page after deletion
            } else {
                alert_toast("Failed to delete program.", 'error');
                end_loader();
            }
        }
    });
}
</script>
<!-- <script>
	$(document).ready(function(){
        $('#create_new').click(function(){
			uni_modal("Program Details","programs/manage_program.php")
		})
        $('.edit_data').click(function(){
			uni_modal("Program Details","programs/manage_program.php?id="+$(this).attr('data-id'))
		})
		$('.delete_data').click(function(){
        var id = $(this).attr('data-id'); // Get the ID from data-id attribute
        _conf("Are you sure to delete this Program permanently?","delete_program",[id]); // Confirm deletion
    })
		$('.view_data').click(function(){
			uni_modal("Program Details","programs/view_program.php?id="+$(this).attr('data-id'))
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
	})
	
	function delete_program(id){
    start_loader();
    $.ajax({	
        url: _base_url_ + "classes/Master.php?f=delete_program",
        method: "POST",
        data: { id: id },
        dataType: "json",
        error: function(err){
            console.log(err);
            alert_toast("An error occurred.", 'error');
            end_loader();
        },
        success: function(resp){
            if(resp.status == 'success'){
                alert_toast("Program deleted successfully.", 'success');
                location.reload(); // Reload the page after deletion
            } else {
                alert_toast("Failed to delete program.", 'error');
                end_loader();
            }
        }
    });
}
</script> -->