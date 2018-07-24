<script type="text/javascript">//<![CDATA[
var SiteUrl = '<?php echo site_url(); ?>';
var UserUrl = '<?php echo site_url(); ?>/users/';
//]]></script>
<script src="<?php echo  base_url(); ?>assests/js/jquery.min.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/toastr.min.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/popper.min.js"></script>
<script src="<?php echo  base_url(); ?>assests/js/bootstrap.min.js"></script>	
<script src="<?php echo  base_url(); ?>assests/js/wow.min.js"></script>	
<script src="<?php echo  base_url(); ?>assests/js/slick.min.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/jquery.validate.min.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/additional-methods.min.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/intlTelInput.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/custom.js"></script>	
<script src="<?php echo  base_url(); ?>assests/js/chhavi.js"></script>	
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZHrvncNkxI08KsBZUrH-9GkIi3WDfzlc&libraries=places&callback=initAutocomplete"></script>
<!-- Modal -->
<div class="modal fade" id="otp" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <i class="fa fa-close"></i>
        </button>
		
      <div class="modal-body">
       <p>Please enter the verification code.  </p>
			<form id="phone_verfiy">
				<div class="form-group">		
					 <input type="text" name="OTP" placeholder="Enter Verification Code">
					 <input type="hidden" name="reference_ID">
				   </div>
			   <div class="form-group">	
				    <input class="btn-hover more-btn" type="submit" value="Submit">
				</div>
				<!-- <a href="#">Resend OTP</a> -->
		     </form>  
      </div>
    </div>
  </div>
</div>
</body>
</html>