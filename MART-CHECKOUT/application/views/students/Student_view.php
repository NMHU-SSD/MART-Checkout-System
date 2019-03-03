<div class="container-fluid">
	<?php echo $this->session->flashdata('message'); ?>

	<h1>Students</h1>
	<br>

	<!-- Search Bar -->
	<input class="form-control float-left col-6" id="input" type="text" placeholder="Search..." />

	<?php if($_SESSION['user_role'] == "Admin" || $_SESSION['user_role'] == "Manager"){?>
	<a class="btn btn-primary float-right mb-4" href = "<?php echo base_url(); ?>students/new">New Student</a>
	<?php } ?>


	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th scope="col">Banner ID</th>
				<th scope="col">Name</th>
				<th scope="col">Email</th>
				<th scope="col">Phone</th>
				<th scope="col">Clearance Levels</th>
				<th scope="col">Amount Owed</th>
				<th scope="col">Enrollment</th>
				<th scope="col">Eligibility</th>
				<?php if( $_SESSION['user_role'] == "Admin" ){ ?>
					<th scope="col">Edit</th>

					<!-- //TODO: verify with Mary if Delete is needed -->
					<th scope="col">Delete</th>
				<?php } ?>
			</tr>
		</thead>
		<tbody id="studentsTable">
			<?php
			$i = 1;
			foreach($records as $r) {
					echo "<tr>";
					echo "<th scope='row'>".$r->banner_id."</th>";
					echo "<td>".$r->name."</td>";
					echo "<td>".$r->email."</td>";
					echo "<td>".$r->phone."</td>";

					$clearance_names = "";
					$array = explode(",", $r->clearance);
					foreach($clearance_options as $option){
						for($j=0; $j < count($array); $j++){
							if($array[$j] == $option->id){
								if(count($array)-1 == $j){
									$clearance_names .= $option->name;
								}else{
									$clearance_names .= $option->name. ', ';
								}
							}
						}
					}
					echo "<td>".$clearance_names."</td>";
					echo "<td>$".$r->amount_owed."</td>";
					echo "<td>".$r->enrollment."</td>";
					echo "<td>".$r->eligibility."</td>";


					if($_SESSION['user_role'] == "Admin"){

						echo "<th scope='col'><a href = '".base_url()."students/edit/".$r->banner_id."'>Edit</a></th>";

						//TODO: verify with Mary if delete is needed - use soft delete for now
						$delete = base_url().'students/hide/'.$r->banner_id;
						echo '<th scope="col"><a href="" data-href="'.$delete.'"data-toggle="modal" data-target="#confirm-delete" data-message="'.$r->banner_id.'" >Delete</a></th>';

					}

					echo "<tr>";
				}
			?>
		</tbody>
	</table>

	<!-- Modal/Pop up -->
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="ModalLabel">Delete Student</h5>
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


<!-- Filtered Search -->
<script>
$(document).ready(function(){
	$("#input").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#studentsTable tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
});
</script>
