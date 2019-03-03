<div class="container-fluid">
	<?php echo $this->session->flashdata('message'); ?>

	<h1>Equipment</h1>
	<br/>

	<!-- Search Bar -->
	<input class="form-control float-left col-6" id="input" type="text" placeholder="Search..." />

  <!-- Search Bar -->
	<?php if($_SESSION['user_role'] == "Admin" || $_SESSION['user_role'] == "Manager"){?>
		<a class="btn btn-primary float-right mb-4" href = "<?php echo base_url(); ?>equipment/new">New Equipment</a>
	<?php } ?>

	<br>
	<table class="table table-bordered table-hover mt-4">
		<thead>
			<tr>
				<th scope="col">Barcode</th>
				<th scope="col">Name</th>
				<th scope="col">Description</th>
				<th scope="col">Clearance Level</th>
				<th scope="col">Notes</th>
				<th scope="col">Account Purchased From</th>
				<th scope="col">Status of Product</th>
				<?php if($_SESSION['user_role'] == "Admin" || $_SESSION['user_role'] == "Manager"){ ?>
				<th scope="col">Edit</th>
				<th scope="col">Delete</th>
				<?php } ?>
			</tr>
		</thead>
		<tbody id="equipmentTable">
			<?php
			$i = 1;
			foreach($records as $r) {
				echo "<tr>";
				echo "<td>".$r->barcode."</td>";
				echo "<td>".$r->name."</td>";
				echo "<td>".$r->description."</td>";

				$clearance_names = "";
				$array = explode(",", $r->clearance);
				foreach($clearance_options as $c){
					for($p=0; $p < count($array); $p++){
						if($array[$p] == $c->id){
							if(count($array)-1 == $p){
								$clearance_names .= $c->name;
							}else{
								$clearance_names .= $c->name. ', ';
							}
						}
					}
				}
				echo "<td>".$clearance_names."</td>";

				// echo "<td>".$r->clearance."</td>";
				echo "<td>".$r->notes."</td>";
				echo "<td>".$r->purchase_account."</td>";
				echo "<td>".$r->status."</td>";

				if($_SESSION['user_role'] == "Admin" || $_SESSION['user_role'] == "Manager"){
					echo "<th scope='col'><a href = '".base_url()."equipment/edit/".$r->barcode."'>Edit</a></th>";
					$delete = base_url().'equipment/delete/'.$r->barcode;
					echo '<th scope="col"><a href="" data-href="'.$delete.'"data-toggle="modal" data-target="#confirm-delete" data-message="'.$r->barcode.'" >Delete</a></th>';
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
					<h5 class="modal-title" id="ModalLabel">Delete Equipment</h5>
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
		$("#equipmentTable tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
});
</script>
