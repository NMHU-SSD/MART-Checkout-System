<div class="container-fluid">
	<?php echo $this->session->flashdata('message'); ?>

	<h1>Students</h1>
	<a class="btn btn-primary float-right m-2" href = "<?php echo base_url(); ?>students/new">New Student</a>

	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Banner ID</th>
				<th scope="col">Name</th>
				<th scope="col">Email</th>
				<th scope="col">Phone</th>
				<th scope="col">Clearance Levels</th>
				<th scope="col">Amount Owed</th>
				<th scope="col">Enrollment</th>
				<th scope="col">Eligibility</th>
				<?php if($_SESSION['user_role'] == "Manager" || $_SESSION['user_role'] == "Admin"){ ?>
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
				if($_SESSION['user_role'] != "Manager" && $r->isDeleted == "0" || $_SESSION['user_role'] == "Manager"){

				echo "<tr>";
				echo "<td>".$i++."</td>";
				echo "<th scope='row'>".$r->banner_id."</th>";
				echo "<td>".$r->name."</td>";
				echo "<td>".$r->email."</td>";
				echo "<td>".$r->phone."</td>";

				$temp = "";
				$pieces = explode(",", $r->clearance_level);
				foreach($clearance as $c){
					foreach($pieces as $p){
						if($p == $c->id){
							$temp .= $c->level .= " ";
						}
					}
				}
				echo "<td>".$temp."</td>";
				// echo "<td>".$r->clearance_level."</td>";

				echo "<td>$".$r->amount_owed."</td>";
				echo "<td>".$r->enrollment."</td>";
				echo "<td>".$r->eligibility."</td>";
				if($_SESSION['user_role'] == "Manager" || $_SESSION['user_role'] == "Admin"){
					if($r->isDeleted == "1"){
						echo "<td>Not Showing</td>";
					}else{
						echo "<td>Showing</td>";
					}
				}

				echo "<th scope='col'><a href = '".base_url()."students/edit/".$r->banner_id."'>Edit</a></th>";

				if($_SESSION['user_role'] == "Manager" || $_SESSION['user_role'] == "Admin"){
					$delete = base_url().'students/delete/'.$r->banner_id;
				}else{
					$delete = base_url().'students/hide/'.$r->banner_id;
				}
				echo '<th scope="col"><a href="" data-href="'.$delete.'"data-toggle="modal" data-target="#confirm-delete" data-message="'.$r->banner_id.'" >Delete</a></th>';
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
