<?php 
if( !empty( $phone_Number ) && !empty( $country_code ) )
{
	//echo "<script> PhoneNumber = '+".$country_code.$phone_Number."' </script>";
}


?>
<main class="internal update_profile login_profile">	
   <section class="profile_area">
	   <div class="container">
	 <div class="update-profile">
		<div class="row">
		  <div class="col-3">
			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
			  <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Update Profile</a>
			  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Change Password</a>
			</div>
		  </div>
		  <div class="col-9">
			<div class="tab-content" id="v-pills-tabContent">
			  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
				  <div class="profile_pic_edite">
			  <div class="form-group">				
					<form  class="custom-file" id="dlf">						
						  <div class="input-file-container"> 
							<input class="input-file" id="my-file" type="file">
							<label tabindex="0" for="my-file" class="input-file-trigger">
					        <figure style="background-image: url(./images/profile-pic.jpg)"></figure>
								<strong>Update Profile Picture</strong></label>
						  </div>
					</form>
				   </div>
			  </div>
				 <div class="update_profile_form">
				  <form id="UpdateInfo">				 
					 <div class="form-group">
						<label>Name</label>
					    <input class="form-control" value="<?php echo $full_Name; ?>" type="text" name="fullname" placeholder="lorem ipsum">
						 <i class="fa fa-pencil" aria-hidden="true"></i>
					  </div>
					  <div class="form-group">
						<label>Email</label>
					    <input class="form-control" value="<?php echo $email; ?>" type="email" name="email" placeholder="@gmail.com">
						  <i class="fa fa-pencil" aria-hidden="true"></i>
					  </div>
					  <div class="form-group">
						<label>Phone Number</label>
					    <input class="form-control" type="text" value="<?php echo $phone_Number; ?>" name="phone_number" placeholder="123 456 7899">
						  <i class="fa fa-pencil" aria-hidden="true"></i>
					  </div>
					  <div class="form-group">
						  <div class="boxes">
						  <input name="is_private" type="checkbox" id="box-1">
						  <label for="box-1">Is Private Profile</label>
						  </div>
                       
					  </div>
					  <div class="form-group">
						<label>Current City & Country of Residence <span>(Optional)</span></label>
					    <input class="form-control" value="<?php echo $details->city.' '.$details->country; ?>" id="autocomplete" name="city_country" type="text" placeholder="Melbourne">
						<input type="hidden" name="City">
						<input type="hidden" name="Country">

					  </div>
					  <div class="form-group">
						<label>About Me </label>
						<textarea name="about_us" class="form-control"><?php echo $details->about_me; ?></textarea>
						  <i class="fa fa-pencil" aria-hidden="true"></i>
					  </div>
					  
					  <div class="form-group">			
					    <input type="submit" value="Submit">
					  </div>					 
					 </form>				  
				  </div>			
				</div>
			  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
				 <div class="update_profile_form">
				  <form id="change_password">
					 <div class="form-group">
						<label>Old Password</label>
					    <input class="form-control" name="old_pass" type="password" placeholder="Old Password">
					  </div>
					  <div class="form-group">
						<label>New Password</label>
					    <input class="form-control" name="new_pass" id="new_pass" type="password" placeholder="New Password">
					  </div>
					  <div class="form-group">
						<label>Confirm New Password</label>
					    <input class="form-control" name="confnew_pass" type="password" placeholder="Confirm Password">
					  </div>
					  <div class="form-group">			
					    <input type="submit" value="Submit">
					  </div>					 
					 </form>				  
				  </div>				
				</div>			
			</div>
		  </div>
		</div>
	  </div>
	 </div>	   
   </section>	
</main>	
	
	