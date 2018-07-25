
<main class="internal">	
	<section class="homeBanner">
		<div class="big-logo fadeInLeft wow only_sign_up_zindex" style="background-image: url('<?php echo base_url(); ?>assests/images/banner.png')">
		<a  class="bn_logo" href="#"><img src="<?php echo base_url(); ?>assests/images/banner_logo.png" alt="banner logo"></a>		
		</div>
		
		
		
		<div class="bannertext zoomIn wow registrationInformation">
			<h2>Sign up</h2>
			<form id="register-1">
					<div class="form-group">
						<label>Select Profile: </label>
					  <div class="select-redio">
					    <input type="radio" class="select-type" name="user_type" value="1" id="P_Profile" >
					    <label for="P_Profile" >Personal Profile</label>
						<input type="radio" class="select-type" name="user_type" value="2" id="B_Profile" >
						<label for="B_Profile">Business Profile</label>
		              </div>
					</div>

					<div class="form-group">
					<label>Register Type: </label>
					  <div class="select-redio">
					    <input type="radio" class="select-type" name="reg_type" value="phone" id="test2" >
					    <label id="otp_password" for="test2" >Phone Number</label>
						<input type="radio" class="select-type" name="reg_type" value="email" id="test3" >
						<label for="test3">Email</label>
		              </div>
					</div>
					<div class="form-group personal-pf">		
						<label>First Name</label>
					 <input name="firstname" class="captalize" type="text">
				   </div>
				   <div class="form-group personal-pf">		
						<label>Surname</label>
					 <input name="surname" class="captalize" type="text">
				   </div>
				   <div class="form-group business-pf">		
						<label>Business Name </label>
					 <input type="text" name="business_name" placeholder="Business Name">
				   </div>
					<div id="phone-hide" class="form-group">		
						<label>Mobile Number</label>
					 <input name="phone_number" type="text">
				   </div>
				   <div style="display:none" class="form-group">		
						<label>Email</label>
					 <input name="email" type="email">
				   </div>
					<div class="form-group">		
						<label>Password</label>
					 <input type="password" id="password" name="password" placeholder="*******">
				   </div>
					<div class="form-group">		
						<label>Confirm Password</label>
					 <input type="password" name="confirm_pass" placeholder="*******">
				   </div>	
				   <div class="form-group">	
					    <input class="btn-hover more-btn register-1" type="submit" value="Next">
					</div>
			</form>		    
		    </div>
		
		   
		<div style="display:none" class="bannertext zoomIn wow profilePic">
			<div class="upload_profile">
			<h2>What do you look like?</h2>
			<form id="register-2" method="POST" enctype="multipart/form-data" >
					<input name="photo_url" value="" type="hidden">
					<div class="form-group">
						  <div class="input-file-container"> 
							<input class="input-file" id="my-file" name="myfile" type="file">
							<label tabindex="0" for="my-file" class="input-file-trigger">
							<span style="background-image: url(./images/upload-pic.png)"></span>						
								<strong>Upload a photo</strong></label>
								<div id="errorContainer"></div>
						  </div>
						  <p class="file-return"></p>
				   </div>
			  		<div class="form-group">	
					    <input class="btn-hover more-btn fileupload" type="submit" value="Next">
					</div>
		   		</form>
		    </div>
	   </div> 

		
		<div style="display:none" class="bannertext zoomIn wow additionalInformation">
			<h2>Sign up</h2>
			<form id="register-3" >
					<div class="form-group">		
						<label>Current City & Country <span> (optional)</span></label>
					 <input type="text" id="autocomplete" name="city_country" placeholder="">
					 <input type="hidden" name="City">
					 <input type="hidden" name="Country">
				   </div>
			   <div class="form-group">	
				    <label>Tell us a bit about yourself <span> ( Optional ) </span></label>
				   <textarea class="caps" name="about_us" placeholder=""></textarea>
				</div>		
			   <div class="form-group">	
				    <input class="btn-hover more-btn" type="submit" value="Create Profile">
				</div>
		     </form>
	    	</div>

	   

     </section>
</main>