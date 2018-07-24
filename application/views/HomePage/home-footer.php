<script type="text/javascript">//<![CDATA[
var SiteUrl = '<?php echo site_url(); ?>';
var UserUrl = '<?php echo site_url(); ?>users/';
var PostUrl = '<?php echo site_url(); ?>posts/';
//]]></script>
<script src="<?php echo  base_url(); ?>assests/js/jquery.min.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/toastr.min.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/popper.min.js"></script>
<script src="<?php echo  base_url(); ?>assests/js/bootstrap.min.js"></script>	
<script src="<?php echo  base_url(); ?>assests/js/jquery.mCustomScrollbar.min.js"></script>	
<script src="<?php echo  base_url(); ?>assests/js/wow.min.js"></script>	
<script src="<?php echo  base_url(); ?>assests/js/slick.min.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/jquery.validate.min.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/additional-methods.min.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/intlTelInput.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/jquery.mCustomScrollbar.min.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/dropzone.min.js"></script> 
<script src="<?php echo  base_url(); ?>assests/js/custom.js"></script>	
<script src="<?php echo  base_url(); ?>assests/js/chhavi.js"></script>	
<script async defer src="https://apis.google.com/js/api.js" onload="this.onload=function(){};HandleGoogleApiLibrary()" onreadystatechange="if (this.readyState === 'complete') this.onload()"></script>
<!-- Modal -->
<div class="modal fade" id="forgot" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <i class="fa fa-close"></i>
        </button>
      <div class="modal-body">
       <p>New Password will be send to following Email/Mobile Number:</p>
			<form method="POST" id="forgot_password">
				<div class="form-group">		
					<input type="text" name="forgot_pass" placeholder="Enter Email/Mobile Number">					 
				   </div>
			   <div class="form-group">	
				    <input class="btn-hover more-btn" type="submit" value="Submit">
				</div>
		     </form>  
      </div>
    </div>
  </div>
</div>
</body>
</html>