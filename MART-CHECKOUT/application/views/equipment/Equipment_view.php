<div class="container-fluid">
	<?php echo $this->session->flashdata('message'); ?>

	<h1>Equipment</h1>
	<br>

	<!-- Search Bar -->
	<input class="form-control" id="myInput" type="text" placeholder="Search..">

	<?php if($_SESSION['user_role'] != "Student Employee"){?>
		<a class="btn btn-primary float-right m-2" href = "<?php echo base_url(); ?>equipment/new">New Equipment</a>
	<?php } ?>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Barcode</th>
				<th scope="col">Name</th>
				<th scope="col">Description</th>
				<th scope="col">Clearance Level</th>
				<th scope="col">Notes</th>
				<th scope="col">Account Purchased From</th>
				<th scope="col">Status of Product</th>
				<?php if($_SESSION['user_role'] != "Student Employee"){?>
					<th scope="col">Edit</th>
					<th scope="col">Delete</th>
				<?php } ?>
			</tr>
		</thead>
		<tbody = id="equipmentTable">
			<?php
			$i = 1;
			foreach($records as $r) {
				echo "<tr>";
				echo "<th scope='row'>".$i++."</th>";
				echo "<td>".$r->barcode."</td>";
				echo "<td>".$r->name."</td>";
				echo "<td>".$r->description."</td>";
				$temp = "";
				$pieces = explode(",", $r->clearance);
				foreach($clearance as $c){
					for($p=0; $p < count($pieces); $p++){
						if($pieces[$p] == $c->id){
							if(count($pieces)-1 == $p){
								$temp .= $c->level;
							}else{
								$temp .= $c->level. ', ';
							}
						}
					}
				}
				echo "<td>".$temp."</td>";

				// echo "<td>".$r->clearance."</td>";
				echo "<td>".$r->notes."</td>";
				echo "<td>".$r->account_purchased_from."</td>";
				echo "<td>".$r->status."</td>";
				if($_SESSION['user_role'] != "Student Employee"){
					echo "<td><a href = '".base_url()."equipment/edit/"
					.$r->barcode."'>Edit</a></td>";

					$delete = base_url().'equipment/delete/'.$r->barcode;
					echo '<th scope="col"><a href="" data-href="'.$delete.'"
					data-toggle="modal" data-target="#confirm-delete" data-message="'.$r->barcode.'" >Delete</a></th>';
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


<!-- Search -->
<script>
$(document).ready(function(){
	$("#myInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#equipmentTable tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
});
</script>
