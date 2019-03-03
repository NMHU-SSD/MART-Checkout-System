<div class="container-fluid">
	<?php echo $this->session->flashdata('message'); ?>

	<h1>Reservations</h1>
	<br/>

	<!-- Search Bar -->
	<input class="form-control col-5 float-left" id="input" type="text" placeholder="Search..">

	<a class="btn btn-primary float-right mb-4" href = "<?php echo base_url(); ?>reservations/new">New Reservation</a>

	<div id="reservations">
		<div class="dropdown">
			<button class="btn btn-primary dropdown-toggle ml-2 float-left" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Sort by
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item sort" data-sort="banner_id" href="#">Banner ID</a>
				<a class="dropdown-item sort" data-sort="status" href="#">Status</a>
				<a class="dropdown-item sort" data-sort="datePickup" href="#">Date Pickup</a>
				<a class="dropdown-item sort" data-sort="dateDue" href="#">Date Due</a>
				<a class="dropdown-item sort" data-sort="timestamp" href="#">Timestamp</a>
			</div>
		</div>
		<br>

		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th scope="col">Equipment Barcodes</th>
					<th scope="col">Student/Faculty Banner ID</th>
					<th scope="col">Date Pickup</th>
					<th scope="col">Date Due</th>
					<th scope="col">Notes</th>
					<th scope="col">Created By</th>
					<th scope="col">Timestamp</th>
					<th scope="col">Edit</th>
					<?php
						if($_SESSION['user_role'] == "Admin"){
							echo '<th scope="col">Delete</th>';
						} else if ($_SESSION['user_role'] == "Manager") {
							echo '<th scope="col">Remove</th>';
						}
					?>
					<th scope="col">Status</th>

				</tr>
			</thead>
			<tbody id="reservationTable" class="list">
				<?php
				$i = 1;
				foreach($records as $r) {
					if( $r->isDeleted != true ){
						// CHeck if student and check if isDeleted to decided if we show to the user
						echo "<tr>";
						echo "<td class='equipment'>".$r->equipment."</td>";
						echo "<td class='banner_id'>".$r->banner_id."</td>";
						echo "<td class='datePickup'>".$r->date_pickup."</td>";
						echo "<td class='dateDue'>".$r->date_due."</td>";
						echo "<td>".$r->notes."</td>";
						//get name from id stored in table
						$user_name = $this->User_Model->get_user_name($r->user_id);
						echo "<td class='created_by'>".$user_name."</td>";

						echo "<td class='timestamp'>".$r->date_time."</td>";

						echo "<th scope='col'><a href = '".base_url()."reservations/edit/".$r->id."'>Edit</a></td>";

						if($_SESSION['user_role'] == "Admin"){
								$delete = base_url().'reservations/delete/'.$r->id;
								$message = "Are you sure you want to delete the reservation for ".$r->banner_id." on the following dates: ".$r->date_pickup." - ".$r->date_due;

								echo '<th scope="col"><a href="" data-href="'.$delete.'"data-toggle="modal" data-target="#confirm-delete" data-message="'.$message.'" >Delete</a></th>';

						} else if ($_SESSION['user_role'] == "Manager"){

								$delete = base_url().'reservations/hide/'.$r->id;
								$message = "Are you sure you want to remove the reservation for ".$r->banner_id." on the following dates: ".$r->date_pickup." - ".$r->date_due;

								echo '<th scope="col"><a href="" data-href="'.$delete.'"data-toggle="modal" data-target="#confirm-delete" data-message="'.$message.'" >Remove</a></th>';
						}

						if ($r->isCheckedOut){
							$reservation_status = "picked up";
						} else{
							$reservation_status = "waiting for pickup";
						}

						echo '<td class="status">'.$reservation_status.'</th>';

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

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js" type="text/javascript"></script>


<!-- Search -->
<script>
	$(document).ready(function(){
		$("#input").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#reservationTable tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
	});

	var options = {
		valueNames: ['banner_id', 'status','datePickup', 'dateDue', 'timestamp' ]
	};
	var list = new List('reservations', options);

	$('.filter').on('click',function(){
		var $q = $(this).attr('data-filter');
		if($(this).hasClass('active')){
			list.filter();
			$('.filter').removeClass('active');
		} else {
			list.filter(function(item) {
				return (item.values().born == $q);
			});
			$('.filter').removeClass('active');
			$(this).addClass('active');
		}
	});
</script>
