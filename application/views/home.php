<!DOCTYPE html>
<html>
<head>
  <title>Home Page</title>
  <style type="text/css">
    div.scrollmenu {
        background-color: #333;
        overflow: auto;
        white-space: nowrap;
    }

    div.scrollmenu a {
        display: inline-block;
        color: white;
        text-align: center;
        padding: 14px;
        text-decoration: none;
    }

    div.scrollmenu a:hover {
        background-color: #777;
    }
  </style>
</head>
<body>
  <div class="scrollmenu">
      <a href="<?php echo site_url('User/index'); ?>">Home</a>
      <a href="<?php echo site_url('User/register_page'); ?>">Register</a>
      <a href="<?php echo site_url('User/login'); ?>">Login</a>
      <a href="#about">About</a>
      <a href="#contactus">Contact Us</a>
  </div>

  <h1>Hello New User.</h1>
  <h2>Welcome to Bank Management System.</h2>

  <h3>Proceed by Registering to Register Page</h3>

      <p>Hey how are you doing?  Hope, you are doing well. Welcome to Bank Management System. You are logged in as: 'New User' privilege. Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
</body>
</html>