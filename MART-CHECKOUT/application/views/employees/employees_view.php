<div class="container-fluid">

	<?php echo $this->session->flashdata('message'); ?>

	<h1>Employees</h1>

	<?php if($_SESSION['user_role'] == "Admin"){?>
		<a class="btn btn-primary float-right mb-4" href = "<?php echo base_url(); ?>employees/new">New Employee</a>
	<?php } ?>


	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th scope="col">Banner ID</th>
				<th scope="col">Name</th>
				<th scope="col">Role</th>

				<?php
					//show edit and delete column
					if($_SESSION['user_role'] == 'Admin'){
						echo '<th scope="col">Edit</th>';
						echo '<th scope="col">Reset Password</th>';
						echo '<th scope="col">Delete</th>';
					}
				?>
			</tr>
		</thead>
		<tbody>

			<?php
			foreach($employees as $employee){
				//dont dispay currently logged in Admin
				if($_SESSION["user_id"] != $employee['banner_id'] && $employee['role'] !="Admin"){
					echo '<tr>';
					echo '<th scope="row">'.$employee['banner_id'].'</th>';
					echo '<td>'.$employee['name'].'</td>';
					echo '<td>'.$employee['role'].'</td>';


					if($_SESSION['user_role'] == 'Admin'){
						//show edit and delete column

						$reset= base_url()."employees/password/".$employee['banner_id'];
						$edit = base_url()."employees/edit/".$employee['banner_id'];
						$delete = base_url()."employees/delete/".$employee['banner_id'];
						echo '<th scope="col"><a href="'.$edit.'">Edit</a></th>';
						echo '<th scope="col"><a href="'.$reset.'">Reset</a></th>';
						echo '<th scope="col"><a href="" data-href="'.$delete.'" data-toggle="modal" data-target="#confirm-delete" data-message="'.$employee['name'].'">Delete</a></th>';

					}

					echo '</tr>';
				}
			}
			?>
		</tbody>
	</table>


	<!-- Modal/Pop up -->
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="ModalLabel">Delete Employee</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<a href="" class="btn-confirm"><button type="button" class="btn btn-primary">Delete</button></a>
				</div>
			</div>
		</div>
	</div>

</div>
