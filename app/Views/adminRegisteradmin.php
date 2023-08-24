<!-- partial -->
      <title>Chandni Halls Online Booking System</title>
      
      <div class="main-panel">
        <div class="content-wrapper">
        
          <div class="row">
          
            <div class="col-md-9 grid-margin stretch-card">
              <div class="card">
                
                <div class="card">
                <div class="card-body">
                  <p class="card-title">Register Admin</p>
                  <?php if(isset($validation)):?>
					<div class="form-row">
						<div class="alert alert-danger"><?= $validation->listErrors() ?></div>
					</div>
				  <?php endif;?>
                  <div class="row">
                    <div class="col-12">
                        <form action="/ManageClient/saveadmin" method="post">

							<div class="form-row" style="margin-bottom: 2%;">
								<div class="form-holder" style="width: 45%; padding-right: 2%;">
									<input type="text" name="first_name" placeholder="First Name" class="form-control">
								</div>
								<div class="form-holder" style="width: 45%;">
									<input type="text" name="last_name"placeholder="Last Name" class="form-control">
								</div>
							</div>
                            
							<div class="form-row" style="margin-bottom: 2%;">
								<div class="form-holder" style="width: 45%; padding-right: 2%;">
									<input type="text" name="email" placeholder="Your Email" class="form-control">
								</div>
								<div class="form-holder" style="width: 45%;">
									<input type="text" name="phone" placeholder="Phone Number" class="form-control">
								</div>
							</div>
							<div class="form-row" style="margin-bottom: 2%;">
								<div class="form-holder" style="width: 45%; padding-right: 2%;">
									<input type="text" name="age" placeholder="Enter Age" class="form-control">
								</div>
								<div class="form-holder" style="width: 45%;">
									<input type="password" name="password" placeholder="Enter new password" class="form-control">
								</div>
							</div>

							<div class="form-row" style="margin-bottom: 2%;">
			
								<div class="form-holder" style="width: 45%;">
									<select name="admin_type" class="form-control adminType">
									<option value="">Select Type</option>
									<option value="1">Super Admin</option>
									<option value="2">Sub Admin</option>
				                    </select>
								</div>
							</div>

							<div>
								<label>
									<input type="hidden" name="terms" value="1"> 
							</div>
							
							<p class="card-title permission d-none">Permissions</p>
							<table class="table table-bordered permission d-none">
								<thead>
								<tr>
									<th>Modules</th>
									<th>View</th>
									<th>Add/Edit</th>
								</tr>
								</thead>
								<tbody>
								
						<?php 
						foreach($permissions as $permission){
                        $roles = $permission->role;
                        $roles = explode(",", $roles);
                        ?>
								<tr>
									<th><?= $permission->title ?></th>
									<?php 
						            $i=0;
									foreach($roles as $role){	
						            $i++; 
						            ?>
									<td><input type="checkbox" name="permission[]" data-val="<?=$permission->permission_id?>_<?=$role?>" value="['<?= $permission->title ?>'=>'<?= $role ?>']" class="form-control checkbox" <?php if($i==1){ ?> style="width: 32%;" <?php }else{ ?> style="width: 20%;" <?php } ?> ></td>
									<?php } ?>
								</tr>
					<?php } ?>

								</tbody>
							</table>
							<br>
							<div class="form-row">
								<div class="form-holder">
									<input type="submit" value="Register" class="form-control submit-button-chandni">
								</div>
								
							</div>
							</form>
                    </div>
                  </div>
                </div>
                  
                  
                  <!--
                  <canvas id="order-chart"></canvas>
                  -->
                  
                  
                  <?php /*?>
                   <p class="card-title">EVENTS - CALENDAR VIEW</p>
                   
                  <iframe src="https://calendar.google.com/calendar/embed?height=700&wkst=1&bgcolor=%23ffffff&ctz=America%2FToronto&src=ZW4uY2FuYWRpYW4jaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%230B8043" style="border-width:0" width="100%" height="700" frameborder="0" scrolling="no"></iframe>
                   
                   <!--
                  <div><img src="https://chandani.dinxstudio.com/assets/images/calendar.jpg" width="100%" height="auto"/></div>
                  -->
                  <?php */?>
                  
                </div>
                
              </div>
            </div>
          </div>
        </div>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script>
		$('.adminType').on('change', function() {
			if($(this).find(":selected").val()==2)
			{
            $('.permission').removeClass('d-none');
			$(".checkbox").removeAttr("checked","checked");
			}
			else
			{
			$('.permission').addClass('d-none');
			$('.checkbox').attr('checked', 'checked');
			}
		});
		$('.checkbox').on('click', function() {
			var id_role = $(this).data("val");
			var parts = id_role.split('_');
			var id = parseInt(parts[0]);
			var role = parts[1];
			if(id_role.toLowerCase().includes('_edit') || id_role.toLowerCase().includes('_add') && $('input[data-val="'+id_role+'"]').prop('checked'))
			{
			   $('input[data-val="'+id+'_List"]').prop('checked', true);
			}
		});

		</script>
        

