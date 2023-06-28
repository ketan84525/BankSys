<?php

$id = $this->session->userdata('uid');

?>

<!DOCTYPE html>
<html>
<head>
  <title>Home Page</title>
  <style type="text/css">
    *{
      margin-top: 10px;
    }

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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" >
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
  <div class="scrollmenu">
      <a href="<?php echo site_url('Account/index'); ?>">Home</a>
      <a href="<?php echo site_url('Account/logout'); ?>">Logout</a>
      <a href="#about">About</a>
      <a href="#contactus">Contact Us</a>
  </div>

  <div class="container">
    <div class="col-md-12">
      <table id="user_list" class="table table-striped table-bordered" style="color: black;">
        <thead>
          <tr style="background:#CCC">
            <th>Sr No</th>
            <th>Username</th>
            <th>Mobile</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>

    </div>
<script type="text/javascript">
    $(function() {
          var trans_data = $('#user_list').DataTable({
            "processing": true,
            "serverSide": true,
            fixedHeader: false,
            "pageLength": 10,
		    'searching':false,
            "language": {
              "infoEmpty": "No data available",
            },
            order: [[2, 'desc'], [1, 'asc']], 
            "ajax" : 
            {
              url: "<?php echo base_url('User/get_user_detail') ?>",
              type: "post"
            }, 
          });
          
        });

</script>

  <p><a style="color: hotpink;" href="<?php echo site_url('Account/logout'); ?>">Log-Out</a></p>
      </div>
</body>
</html>