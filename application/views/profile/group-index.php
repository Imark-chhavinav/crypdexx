 <div class="middile_content_right">
				<div class="creat_channel_server">
					<form id="create-group">
					<div class="create_channel_inner padding-no-bottom">
						    <h3>Create Group</h3>	
							  <div class="create_channel">	
								  <div class="row">
									 <div class="col-md-6">	
								  	     <div class="form-group">
											<label>Group Name</label>
											 <input type="text" name="group_name" placeholder="Group Name">
									     </div>
									     <div class="form-group">
											<label>Group Description</label>
											<textarea class="form-control" rows="5" name="group_desc"></textarea>
									     </div>
								       </div>
									  <div class="col-md-6">
										  <div class="custom_menu">
										       <div class="input-file-container">
												<div class="file">
													<input onchange="readURL(this)" class="input-file" id="my-file" name="group-pic" type="file">
												</div>
												<label tabindex="0" for="my-file" class="input-file-trigger">
														<span class="read-it"  style="background-image: url(<?php echo site_url().'assests' ?>/images/group.jpg)"></span>					
													<strong>Upload Group Photo</strong>
												</label>
										      </div>
									         <p class="file-return">(Recommended Size 100X100 Pixels)</p>					  
										  </div>				             
									 </div>
							  </div>
								<div class="row">
								 <div class="would_you_admin">
									<label class="border-bottom">Would you like to add anothe admin to your group?</label>
									   <div class="create_channel_inner padding-no-bottom padding-no-top">
										 <div class="redio_btn">
												 <input type="radio" id="test1" name="radio-group" checked="">
												 <label for="test1">Yes</label>
												 <input type="radio" id="test2" name="radio-group">
												 <label for="test2">No</label>
										  </div>	
						<div class="form-group double_button">
									<div class="row">
									 <div class="col-md-4">	
										<label>Admin 1</label>
										 <input type="text" placeholder="User Name">
										 <select class="custom_select">
										   <option>Select your role</option>
										   <option>Admin</option>
										   <option>Indi</option>
										</select>
									</div>
								 <div class="col-md-4">	
									 <label>Admin 2</label>
									   <input type="text" placeholder="User name">
										<select class="custom_select">
										   <option>Select your role</option>
										   <option>Select your role 1</option>
										   <option>Select your role 2</option>
										</select>
								  </div>	
								</div>
						</div>
						<div class="form-group justify-content-end add_more">
						   <button class="add_more_option"><i class="fa fa-plus" aria-hidden="true"></i> Add More</button>
						</div>						
					</div>
			  </div> 
	   </div>  
           <div class="row">
			   <div class="col-md-6">	
					<div class="form-group">
							<label>Add some members to your group</label>
						              <div class="enter_name">
										 <input type="text" placeholder="Enter names">	
										  <i class="fa fa-plus" aria-hidden="true"></i>
						              </div>									 							
									     </div>								   
								       <div class="form-group">
										 <label>Select the privacy of your group</label>
											<select name="group_privacy" class="custom_select">
											   <option value="">Select </option>
											   <option value="1">Only Admin can post</option>
											   <option value="2">All members can post</option>
											</select>				
								         </div>	
								     </div>
							  </div>
					<div class="row">
						<div class="col-md-12">
						   <div class="form-group submitcenter justify-content-end">
						    <input type="submit" class="btn-hover more-btn create-group" value="Create Group">
						 </div>		  
					</div>		  
				</div>								  
          </div>	
		</div>
		</form>				
	  </div>
	   </div>