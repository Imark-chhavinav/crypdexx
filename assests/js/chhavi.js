$(document).ready(function()
{	
	/* Flag DropDown */
	$("input[name='phone_number']").intlTelInput();
	
	/* if( PhoneNumber != '' )
	{
		$("input[name='phone_number']").intlTelInput("setNumber", PhoneNumber);		
	} */

	/* Show Email or Phone Number Field On Selection  */
	$( '.select-type' ).click(function()
	{
		var Type = $(this).val();

		if( Type == 'phone' )
		{
			$( '#phone-hide' ).show();
			$( 'input[name="email"]' ).parent( '.form-group' ).hide();
			$( 'input[name="email"]' ).val( "" );
		}
		else if( Type == 'email' )
		{
			$( 'input[name="email"]' ).parent( '.form-group' ).show();
			$( 'input[name="phone_number"]' ).val( "" );
			$( '#phone-hide' ).hide();			
		}
	});

	$( '.select-type' ).click(function()
	{
		var Type = $(this).val();

		if( Type == '1' )
		{
			$('.personal-pf').show();
			$('.business-pf').hide();
			$('input[name="business_name"]').val("");
		}
		else if( Type == '2' )
		{
			$('.personal-pf').hide();
			$('.business-pf').show();	
			$('input[name="firstname"]').val("");
			$('input[name="surname"]').val("");
		}
	});



	/*  Dropzone Js */
	
	if( $( '#id_dropzone' ).length > 0 )
	{
		Dropzone.autoDiscover = false;			
		var myDropzone = new Dropzone("#id_dropzone", { 
	    url: PostUrl+'InsertMedia',
	    autoProcessQueue:false,
	    paramName : 'file',		
		parallelUploads: 100,		
		clickable: ".buttonText,#id_dropzone,.dz-clickable",
		queuecomplete:function()
		{
			$(".dz-remove").hide();
			//location.reload();			
		},		
		init: function ()
		{
	        this.on("sending", function (file, xhr, formData, e) {
				formData.append("refrence_ID", $( 'input[name="refrence_ID"]' ).val()); 
				//formData.append("action", "lessonplan"); 			
				//formData.append("_wpnonce", $("#_wpnonce").val());                
			});	

	        this.on("maxfilesexceeded", function(file) 
	        {
	            this.removeAllFiles();
	            this.addFile(file);
	     	});

	     	/*this.on("complete", function(file) 
	        {
	        	console.log( file );
	        	if( file.status == 'success' )
	        	{
					toastr.success( 'Media Uploaded. Post will be publish soon.', 'Success !');
							
	        	}	
	        	else
	        	{
	        		toastr.error( 'There was an Error in Uploading Media!', 'Error !');		
	        	}            
	     	});*/
	     }
	  });

		myDropzone.on("addedfile", function(file) {
		  // Hookup the start button
		  $( '#id_dropzone' ).removeClass( 'hidden' );
		});

		$('#start-publish').click(function() 
		{
			var TextContent = $( 'textarea[name="post_content"]' ).val();
			if( TextContent.length == 0 )
			{
				toastr.error( 'Post Content Required!', 'Error !');
				$( 'textarea[name="post_content"]' ).addClass('error');
			}
			else
			{
				$( 'textarea[name="post_content"]' ).removeClass('error');
				$.ajax(
				{
					type : 'POST',
					url  : PostUrl+'InsertPost',
					data : { 'post_content' : TextContent , 'post_type' : 'user_post' },
					success:function(res)
					{
						var Obj = jQuery.parseJSON( res );
						if( Obj.success == 1 )
						{
							 if (myDropzone.getQueuedFiles().length > 0) 
								{                        
		                           $( 'input[name="refrence_ID"]' ).val( Obj.result );
									myDropzone.processQueue();  
		                        }
	                        else
		                        {
		                        	toastr.success( 'Post Created Successfully', 'Success !');
		                        	setTimeout(function(){ location.reload(); },3000) 	;
		                        }
							
						}
					else					
						{
							toastr.error( Obj.error, 'Error Chhavi !');						
						}
					}
				});
			}	   		   
		});
	}
	

	/* Sign Up Validation */
	$("#register-1").validate({
			rules: {
				user_type	: { required : true },
				reg_type	: { required : true },
				firstname	: { required : function(element) { return $("input[name='user_type']:checked").val() == '1'; }, lettersonly : true },				
				surname		: { required : function(element) { return $("input[name='user_type']:checked").val() == '1'; }, lettersonly : true },				
				email		: { required : function(element) { return $("input[name='reg_type']:checked").val() == 'email'; } , email : true },				
				business_name : { required : function(element) { return $("input[name='user_type']:checked").val() == '2'; } },				
				phone_number: { required : function(element) { return $("input[name='reg_type']:checked").val() == 'phone'; } , digits : true , maxlength : 15 },				
				password	: { required : true , minlength : 6 },								
				confirm_pass: { required : true , equalTo: "#password" }								
			},
			submitHandler: function(form)
			{
				var fd = new FormData();
				$.each($("#register-1").serializeArray(), function(i, field) {
				  fd.append(field.name, field.value);
				});
				fd.append('country_code', $( '.country.active' ).attr( 'data-dial-code' ) );			
					
				$.ajax({
				  type: "POST",
				  url: UserUrl+'InsertUser',
				  data: fd,
				  processData: false,
				  contentType: false,
				  success: function(res) 
				  {	
				  	var Obj = jQuery.parseJSON( res );
					if( Obj.success == 1 )
					{
						toastr.success( Obj.result, 'Success');	
						$( '.registrationInformation' ).hide();					
						$( '.profilePic' ).show();
					}
					else if( Obj.success == 2 )
					{
						$( '#otp' ).modal( 'show' );
						$( 'input[name="reference_ID"]' ).val( Obj.result );						
					}
					else
					{
						toastr.error( Obj.error, 'Error !');						
					}
				  }
				});
			}
	});

	/* Sign Up Upload Profile Pic */
	$( '.fileupload' ).click(function(e)
	{
		/* Prevent Form From Submission */
		e.preventDefault();
		$( "#register-2" ).validate({
		  rules: {
			    myfile: {
			      required: true,
			      accept: "image/jpg,image/jpeg,image/png,image/gif"
			    }
			}
		});

		if( $( '#register-2' ).valid() )
		{
			$( '.profilePic' ).hide();
			$( '.additionalInformation' ).show();
		}
	});
	

	/* Country and Information */
	$( "#register-3" ).validate({
	  rules: {
	    city_country: {
	      required: true	     
	    }
	  },
	  submitHandler: function(form)
		{
			/* Get all Forms Data */
			var fd = new FormData();
			
			$.each($("#register-3").serializeArray(), function(i, field) {
			  fd.append(field.name, field.value);
			});

			fd.append('attachment', $('#my-file')[0].files[0]);			
			fd.append('photo_url', $('input[name="photo_url"]').val());			
			fd.append('reference_ID', $('input[name="reference_ID"]').val());			
			$.ajax({
				  type: "POST",
				  url: UserUrl+'UpdateUser',
				  data: fd,
				  processData: false,
				  contentType: false,
				  success: function(res) 
				  {	
				  	var Obj = jQuery.parseJSON( res );
					if( Obj.success == 1 )
					{
						toastr.success( Obj.result, 'Success');
						window.location = SiteUrl;						
					}
					else
					{
						toastr.error( Obj.error, 'Error !');						
					}
				  }
				});
		}
	});

	/* OTP VERIFICATION */

	$( "#phone_verfiy" ).validate({
	  rules: {
	    OTP: {
	      required: true,
	      maxlength: 6,
	      minlength: 6	     
	    }
	  },
	  submitHandler: function(form)
		{
			/* Get all Forms Data */
			var fd = new FormData();
			$.each($("#phone_verfiy").serializeArray(), function(i, field) {
			  fd.append(field.name, field.value);
			});
					
			$.ajax({
				  type: "POST",
				  url: UserUrl+'VerifyCode',
				  data: fd,
				  processData: false,
				  contentType: false,
				  success: function(res) 
				  {	
				  	var Obj = jQuery.parseJSON( res );
					if( Obj.success == 1 )
					{
						toastr.success( Obj.result, 'Success');
						$( '#otp' ).modal( 'hide' );
						$( '.registrationInformation' ).hide();					
						$( '.profilePic' ).show();						
					}
					else
					{
						toastr.error( Obj.error, 'Error !');						
					}
				  }
				});
		}
	});

	/* SignIN  */
	$( "#signIN" ).validate({
	  rules: {
	    sign_in: {
	      required: true	     
	    },
	    password: {
	      required: true	     
	    }
	  },
	  submitHandler: function(form, event)
		{
			event.preventDefault();
			/* Get all Forms Data */
			var fd = new FormData();			
			$.each($("#signIN").serializeArray(), function(i, field) {
			  fd.append(field.name, field.value);
			});					
			$.ajax({
				  type: "POST",
				  url: UserUrl+'UserSignIn',
				  data: fd,
				  processData: false,
				  contentType: false,				
				  success: function(res) 
				  {				  		
				  	var Obj = jQuery.parseJSON( res );
				  	console.log( Obj );
					if( Obj.success == 1 )
					{
						toastr.success( Obj.result, 'Success');
						window.location = SiteUrl;						
					}
					else
					{
						toastr.error( Obj.error, 'Error !');						
					}
				  }
				});
		}
	});

	/* Forgot Password */	
	$( "#forgot_password" ).validate({
	  rules: {
	    forgot_pass: {
	      required: true	     
	    }
	  },
	  submitHandler: function(form)
		{
			/* Get all Forms Data */
			var fd = new FormData();
			
			$.each($("#forgot_password").serializeArray(), function(i, field) {
			  fd.append(field.name, field.value);
			});
			
			$.ajax({
				  type: "POST",
				  url: SiteUrl+'ForgotPass',
				  data: fd,
				  processData: false,
				  contentType: false,
				  success: function(res) 
				  {					
				  	var Obj = jQuery.parseJSON( res );
					if( Obj.success == 1 )
					{
						toastr.success( Obj.result, 'Success');
						$('#forgot_password')[0].reset();						
						location.reload();
					}
					else
					{
						toastr.error( Obj.error, 'Error !');						
					} 
				  }
				});
		}
	});
	
	/* Change Password */	
	$( "#change_password" ).validate({
	  rules: {
	    old_pass: {
	      required: true	     
	    },
		new_pass: {
	      required: true	     
	    },
		confnew_pass: {
			required: true,
			equalTo: "#new_pass"		  
	    }
	  },
	  submitHandler: function(form)
		{
			/* Get all Forms Data */
			var fd = new FormData();			
			$.each($("#change_password").serializeArray(), function(i, field) {
			  fd.append(field.name, field.value);
			});
			
			$.ajax({
				type: "POST",
				url: UserUrl+'ChangePassword',
				data: fd,
				processData: false,
				contentType: false,
				success: function(res) 
				  {					
				  	var Obj = jQuery.parseJSON( res );
					if( Obj.success == 1 )
					{
						toastr.success( Obj.result, 'Success');
						$('#change_password')[0].reset();						
						setTimeout(function(){ location.reload(); },2000);
					}
					else
					{
						toastr.error( Obj.error, 'Error !');						
					}
				  }
				});
		}
	});

	/* Update User Information */	
	$( "#UpdateInfo" ).validate({
	  rules: {
	    fullname: {
	      required: true	     
	    },
		email: {
	      email: true	     
	    },	
		city_country: {
	      required: true	     
	    },		
	  },
	  submitHandler: function(form)
		{
			/* Get all Forms Data */
			var fd = new FormData();			
			$.each($("#UpdateInfo").serializeArray(), function(i, field) {
			  fd.append(field.name, field.value);
			});
			
			$.ajax({
				type: "POST",
				url: UserUrl+'ChangePassword',
				data: fd,
				processData: false,
				contentType: false,
				success: function(res) 
				{
					console.log( res );	
				  	/* var Obj = jQuery.parseJSON( res );
					if( Obj.success == 1 )
					{
						toastr.success( Obj.result, 'Success');
						$('#change_password')[0].reset();						
						setTimeout(function(){ location.reload(); },2000);
					}
					else
					{
						toastr.error( Obj.error, 'Error !');						
					} */
				}
				});
		}
	});

	/*  Ico bench Scroll load data  */
	if( $( '.ico-bench' ).length > 0 )
	{
		getIcoBench();
		$(window).scroll(function() 
		{
			if($(window).scrollTop() == $(document).height() - $(window).height()) 
			{
				var Icopage = $( '.ico-bench' ).attr( 'data-page' );
				getIcoBench( Icopage );				
			}
		});
	}

	/* Creating group */	
	$( "#create-group" ).validate({
	ignore: [],
	errorPlacement: function(error, element) 
		{           
            if (element.attr("name") == "group-pic" ) 
            {
                $(".file-return").after( error.append());
            }            
            else 
            {
            	$(element).after( error.append());                
            }
        },               
	rules: 
	  	{
		    group_name		: { required: true },
		    group_desc		: { required: true },
		    group_privacy	: { required: true },	    
		    "group-pic": {	
			      required: true,
			      accept: "image/jpg,image/jpeg,image/png,image/gif"
				}
	  },
	  invalidHandler: function(form, validator) {

        if (!validator.numberOfInvalids())
            return;

        $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top - 100
        }, 2000);

    },   	
	  submitHandler: function(form)
		{
			/* Get all Forms Data */
			var fd = new FormData();
			
			$.each($("#create-group").serializeArray(), function(i, field) {
			  fd.append(field.name, field.value);
			});

			fd.append('file', $('#my-file')[0].files[0]);		
			
			console.log( fd );		
			$.ajax({
				  type: "POST",
				  url: SiteUrl+'Group/InsertGroup',
				  data: fd,
				  processData: false,
				  contentType: false,
				  success: function(res) 
				  {	
				  	var Obj = jQuery.parseJSON( res );
					if( Obj.success == 1 )
					{
						toastr.success( Obj.result, 'Success');
						window.location = SiteUrl;						
					}
					else
					{
						toastr.error( Obj.error, 'Error !');						
					}
				  }
				});
		}
	});
});


/* Facebook SignIn */

window.fbAsyncInit = function() {
    // FB JavaScript SDK configuration and setup
    FB.init({
      appId      : '1093102690836745', // FB App ID
      cookie     : true,  // enable cookies to allow the server to access the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });
    
    // Check whether the user already logged in
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            //display user data
            //getFbUserData();
            fbLogout();
        }
    });
};
// Load the JavaScript SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Facebook login with JavaScript SDK
function fblogin() 
{
	FB.login(function (response) 
	    {    	
	    	
		 if (response.authResponse) 
	        {            
	            getFbUserData();
	        }
	    else 
	        {
	        	toastr.error( 'User cancelled login or did not fully authorize.', 'Error !');			           
	        }

	    }, {scope: 'email'});

}

/* Fb Login Get User Data */
	// Fetch the user profile data from facebook
function getFbUserData(){
    FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
    function (response) {    	
    console.log( response );
    	$.ajax({
			type:'POST',
			url:UserUrl+'SocialLogin',
			data:{ 'email':response.email , 'fullname' : response.first_name+' '+response.last_name, 'FBID':response.id, 'Image_url' : response.picture.data.url},
			success:function(res)
			{
				console.log(res);
				var Obj = jQuery.parseJSON( res );
					if( Obj.success == 1 )
					{
						toastr.success( Obj.result, 'Success');	
						window.location = SiteUrl;
					}
					else
					{
						toastr.error( Obj.result, 'Error');
					}
			}
		});
    });
}


// Logout from facebook
function fbLogout() {
    FB.logout(function() {
        /*document.getElementById('fbLink').setAttribute("onclick","fbLogin()");
        document.getElementById('fbLink').innerHTML = '<img src="fblogin.png"/>';
        document.getElementById('userData').innerHTML = '';
        document.getElementById('status').innerHTML = 'You have successfully logout from Facebook.';*/
    });
}

/* Google Login */
function HandleGoogleApiLibrary() {
	// Load "client" & "auth2" libraries
	gapi.load('client:auth2', {
		callback: function() {
			// Initialize client library
			// clientId & scope is provided => automatically initializes auth2 library
			gapi.client.init({
		    	apiKey: 'T8QJgdftS27g3GEtVgiM5YaU',
		    	clientId: '683662830858-uefh7m7t5rha22uhb69ruv549sp510nr.apps.googleusercontent.com',
		    	scope: 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me'
			}).then(
				// On success
				function(success) {
			  		// After library is successfully loaded then enable the login button
			  		console.log(success);
				}, 
				// On error
				function(error) {
					alert('Error : Failed to Load Library');
			  	}
			);
		},
		onerror: function() {
			// Failed to load libraries
		}
	});
}

function GoogleLogin()
{
	gapi.auth2.getAuthInstance().signIn().then(
		// On success
		function(success) {
			// API call to get user information
			gapi.client.request({ path: 'https://www.googleapis.com/plus/v1/people/me' }).then(
				// On success
				function(success) 
				{
					var user_info = JSON.parse(success.body);
					console.log(user_info);
						$.ajax({
							type:'POST',
							url:UserUrl+'SocialLogin',
							data:{ 'email':user_info.emails[0].value , 'fullname' : user_info.displayName, 'FBID':user_info.id, 'Image_url' : user_info.image.url},
							success:function(res)
							{
								console.log(res);
								var Obj = jQuery.parseJSON( res );
									if( Obj.success == 1 )
									{
										toastr.success( Obj.result, 'Success');	
										window.location = SiteUrl;
									}
									else
									{
										toastr.error( Obj.result, 'Error');
									}
							}
						});					
				},
				// On error
				function(error) 
				{									
					toastr.error( 'Failed to get user user information', 'Error !');							
				}
			);
		},
		// On error
		function(error) {
			$("#login-button").removeAttr('disabled');
			toastr.error( 'Login Failed ! Please register ', 'Error !');
		}
	);
}

function getIcoBench( getPage = 0 )
{
	if( working == 0 )
	{	
		working = 1;
		$( '.ico-loader' ).removeClass( 'hidden' );
		window.scrollBy(0, -100);
		$.ajax({
			type : 'POST',
			url  : SiteUrl+'Ico/getListing/'+getPage,
			data :{ 'format' : 'html' },
			success:function(res)
			{
				working = 0;
				$( '.ico-loader' ).addClass( 'hidden' );
				var old = parseInt(getPage);
				var NewPage = old + 1 ;			
				$( '.ico-bench' ).attr( 'data-page' , NewPage );
				var Obj = jQuery.parseJSON( res );
				$.each(Obj.result, function(key, value) 
				{
					//console.log(value);
					$( '.video_articale' ).append( value );
				});
			}
		});
	}
}

