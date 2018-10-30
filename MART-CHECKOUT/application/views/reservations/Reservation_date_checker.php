<div class="container">
	<div class="row pl-2 pr-2">
		<div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
			<h1>Check Reservation Due Date</h1>
			<br>

			<!-- NOTE: THIS SCRIPT IS FOR WINDOWS TASK SCHEDULER TO BE RAN -->
			<!-- NOTE: AT 9PM EVERYDAY -->

			<?php
			//set time zone
			date_default_timezone_set("America/Denver");

			// date("m/d/Y g:i A") return string
			// returned value = 10/28/2018 1:40 AM
			$curr_date = date("Y/m/d g:i A");

			foreach ($records as $r) {
				echo $r->student_id.'<br>';
				echo $r->date_due.'<br>';

				$d=strtotime($r->date_due);
				$compare_date = date("Y/m/d g:i A", $d);

				// TODO: once figured out change equipment back to available
				if($curr_date > $compare_date){
					echo "<td><a href = '".base_url()."reservations/check_due_date/"
					.$r->barcode."'>Delete Reservation and Equipment now aviable</a></td><br>";
				}
				echo '<br><br>';
			}

			echo '<br><br><br>';
			?>
		</div>
	</div>
</div>
