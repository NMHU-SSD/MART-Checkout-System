<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-5">


	<a class="navbar-brand mb-0 h1 mr-5" href="<?php echo base_url(); ?>">MART Checkout System</a>

	<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
			<?php
				foreach ($nav_items as $key => $value) {
					$url = base_url().$value;
					echo '<li class="nav-item">';
					echo "<a class='nav-link' href='$url' onClick='window.location.href = $url'>".$key."</a>";
					echo '</li>';
				}

			?>
		</ul>

		<?php echo form_open('dashboard/logout'); ?>
			<input type="submit" class="btn btn-light" id="btn_logout" name="btn_logout" value="LOGOUT"/>
		<?php echo form_close(); ?>

	</div>

</nav>
