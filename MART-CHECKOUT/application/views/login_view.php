<div class="container">

	<div class="row pl-2 pr-2">

		<div class="col-sm-6 col-md-5 col-md-5 ml-auto mr-auto mt-5">

			<?php echo $this->session->flashdata('message'); ?>

			<?php echo form_open('login/verify', 'autocomplete="off"'); ?>

			<h1 class="text-center">MART Checkout System</h1>

			<!-- banner id -->
			<div class="form-group mt-5">

				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">@</span>
					</div>
					<input class="form-control" id="form_id" name="form_id" placeholder="Banner ID" type="text" autocomplete="off"  aria-describedby="basic-addon1" value="" />
				</div>

				<!-- Password for managers/assistants-->
				<div class="form-group mt-2" id="password">
					<input type="password" class="form-control" id="form_password" name="form_password" placeholder="Manager/Assistant Password" type="text"  autocomplete="off" aria-describedby="basic-addon1" value="" />
				</div>
			</div>

			<span class="text-danger"><?php echo form_error('form_id'); ?></span>

			<!-- login button -->
			<div class="form-group mt-3">
				<input type="submit" id="btn_login" name="btn_login" value="Login" class="btn btn-primary btn-block"/>
			</div>

			<?php echo form_close(); ?>

		</div>
	</div>
</div>
