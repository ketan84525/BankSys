<!DOCTYPE html>
 <html>
 <head>
 	<title>Login Form</title>
 	<style type="text/css">
    input[type=text], input[type=email], input[type=password], select {
      width: 100%; 
      padding: 12px; 
      border: 1px solid #ccc; 
      border-radius: 4px; 
      box-sizing: border-box; 
      margin-top: 6px; 
      margin-bottom: 16px; 
      resize: vertical;
    }


    input[type=submit] {
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }


    input[type=submit]:hover {
      background-color: #45a049;
    }


    .container {
      border-radius: 5px;
      background-color: #f2f2f2;
      padding: 20px;
    }

  </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
 </head>
 <header>
   <h1>Welcome to Bank Management System</h1>
 </header>
 <body bgcolor="Gainsboro">
 	<?php 
 		$emsg = $this->session->flashdata("emsg");

 		if($emsg){
 			echo $emsg;
 		}
 	?>
 	<h3><?php echo $emsg;?></h3>
 	<h3>Login Page</h3>
     <div class="container">
 	    <form method="POST" action="">
 		    <table>
                <tr><td>User Name: <input type="text" id="username" name="username" placeholder="Enter Your Name"></td></tr>
 			    <tr><td>Password: <input type="password" id="password" name="password" placeholder="Enter Your Password"></td></tr>
 			    <tr><td><input type="submit" id="submit" name="submit" value="Login"></td></tr>
 		    </table>
 		    <p>Not Registered! <a href="<?php echo site_url('User/register_page'); ?>">Register Here</a></p>
 	    </form>
    </div>
  <script type="text/javascript">
    $(document).ready(function(){ 
      $("#submit").on('click', function(e){
        e.preventDefault();

        var name = $('#username').val();

        var password = $('#password').val();

          $.ajax({
            type: "POST",
            url: "<?php echo base_url("User/validate_user"); ?>",
            dataType: 'json',
            data: {
              namei: name,
              passwordi: password
            },
            success: function (res) {
              var dataResult = JSON.parse(JSON.stringify(res));
              if (dataResult.status == 200) {
                if(dataResult.type == 'banker') {
                  window.location.replace("<?php echo base_url('Account/bankerpage'); ?>");
                }else {
                  window.location.replace("<?php echo base_url('Account/index'); ?>");
                }
              }
              else {
                alert("Incorrect Name, Email, Password");
              }
            }
          });
    });
  });
  </script>
 </body>
 </html>