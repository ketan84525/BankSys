<!DOCTYPE html>
 <html>
 <head>
 	<title>Registeration Form</title>
 	<style type="text/css">
 		* {box-sizing: border-box}

		.container {
  			border-radius: 5px;
      		background-color: #f2f2f2;
      		padding: 20px;
		}

		input[type=text], input[type=password], input[type=email] {
  			width: 100%; 
      		padding: 12px; 
      		border: 1px solid #ccc; 
      		border-radius: 4px; 
      		box-sizing: border-box; 
      		margin-top: 6px; 
      		margin-bottom: 16px; 
      		resize: vertical;
		}

		input[type=text]:focus, input[type=password]:focus, input[type=email]:focus {
  			background-color: #ddd;
  			outline: none;
		}

		.registerbtn {
			background-color: #4CAF50;
			color: white;
			padding: 16px 20px;
			margin: 8px 0;
			border: none;
			cursor: pointer;
			width: 100%;
			opacity: 0.9;
		}

		.registerbtn:hover {
  			opacity:1;
		}

		a {
  			color: dodgerblue;
		}
 	</style>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
 	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
 </head>
 <body>
 	<?php 
 		$smsg = $this->session->flashdata("smsg");
 		$emsg = $this->session->flashdata("emsg");

 		if($smsg){
 			echo $smsg;
 		}

 		if($emsg){
 			echo $emsg;
 		}
 	?>
 	<h3><?php echo $smsg;?></h3>
 	<h3><?php echo $emsg;?></h3>
 	<div class="top-container" style="background-color: GhostWhite;">
 		<header>
 			<h1>Register</h1>
    		<p>Please fill in this form to create an account.</p>
    	</header>
    </div>
    <div class="container"> 	
    <form id="uploadform" method="POST" enctype="multipart/form-data">
 		<table>
 			<tr><td>Name: <input type="text" id="name" name="name" placeholder="Enter Your Name"></td></tr>
 			<tr><td>User Name: <input type="text" id="uname" name="uname" placeholder="Enter Your User Name"></td></tr>
 			<tr><td>Password: <input type="password" id="password" name="password" placeholder="Enter Your Password"></td></tr>
 			<tr><td>Email: <input type="email" id="email" name="email" placeholder="Enter Your Email ID"></td></tr>
 			<tr><td>Mobile: <input type="text" id="mobile" name="mobile" placeholder="Enter Your Mobile"></td></tr>
             <tr><td>
                <label for="usertype">Choose a Usertype:</label>
                <select name="usertype" id="usertype">
                <option value="">--Select--</option>
                <option value="banker">Bankers</option>
                <option value="customer">Customers</option>
                </select> </td></tr>
            <tr><td><input type='submit' class="btn btn-primary" name='btnSave' id="btnSave" value='Register' /></td></tr>
 		</table>
 		<p>Already Registered!<a href="<?php echo base_url('User/login'); ?>">Login Here</a></p>
 	</div>
 	</form>
 	<script type="text/javascript">
 		$(document).ready(function(){ 
 			$("#btnSave").on('click', function(e){
 				e.preventDefault();

 				var formData = new FormData($("#uploadform")[0]);

 				$.ajax({
 					type: "POST",
 					url: "<?php echo base_url("User/register"); ?>",
 					dataType: 'json',
 					data: formData,
 					cache: false,
                    processData: false,
                    contentType: false,
 					success: function (res) {
						var dataResult = JSON.parse(JSON.stringify(res));
 						if (dataResult.status == 200) {
 							alert('User Registered Successfully');
							window.location.replace("<?php echo base_url('User/login'); ?>");
 						}
 						else{
 							alert('An Error Occurred! Try again Later');
 						}
 					}
 				});
 			});
 		});
 	</script>
 </body>
 </html>