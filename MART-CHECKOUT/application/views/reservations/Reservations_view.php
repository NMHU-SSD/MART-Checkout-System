<div class="container-fluid">
	<?php echo $this->session->flashdata('message'); ?>

	<h1>Reservations</h1>
	<a class="btn btn-primary float-right m-2" href = "<?php echo base_url(); ?>reservations/new">New Reservation</a>

	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Equipment Barcode</th>
				<th scope="col">Student Banner ID</th>
				<th scope="col">Date Pickup</th>
				<th scope="col">Date Due</th>
				<th scope="col">Notes</th>
				<th scope="col">Created By</th>
				<th scope="col">Timestamp</th>
				<?php if($_SESSION['user_role'] != "Student Employee"){ ?>
					<th scope="col">Hidden</th>
				<?php } ?>
				<th scope="col">Edit</th>
				<th scope="col">Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			foreach($records as $r) {

				if($_SESSION['user_role'] == "Student Employee" && $r->isDeleted == "0" || $_SESSION['user_role'] != "Student Employee"){
					// CHeck if student and check if isDeleted to decided if we show to the user
					echo "<tr>";
					echo '<th scope="row">'.$i++."</th>";
					echo "<td>".$r->barcode."</td>";
					echo "<td>".$r->student_id."</td>";
					echo "<td>".$r->date_pickup."</td>";
					echo "<td>".$r->date_due."</td>";
					echo "<td>".$r->notes."</td>";
					//get name from id stored in table
					$user_name = $this->User_Model->get_user_name($r->user_id);
					echo "<td>".$user_name."</td>";

					echo "<td>".$r->date_time."</td>";
					if($_SESSION['user_role'] != "Student Employee"){
						if($r->isDeleted == "1"){
							echo "<td>Not Showing</td>";
						}else{
							echo "<td>Showing</td>";
						}
					}
					echo "<td><a href = '".base_url()."reservations/edit/".$r->barcode."'>Edit</a></td>";

					if($_SESSION['user_role'] != "Student Employee"){
						$delete = base_url().'reservations/delete/'.$r->barcode;
					}else{
						$delete = base_url().'reservations/hide/'.$r->barcode;
					}
					$message = "the reservation for ".$r->barcode." on the following dates: ".$r->date_pickup." - ".$r->date_due;

					echo '<th scope="col"><a href="" data-href="'.$delete.'"data-toggle="modal" data-target="#confirm-delete" data-message="'.$message.'" >Delete</a></th>';
					echo "<tr>";
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
					<h5 class="modal-title" id="ModalLabel">Delete Reservation</h5>
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
