<?php

$id = $this->session->userdata('uid');

$mode = $this->session->userdata('mode');

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
      <table id="trans_list" class="table table-striped table-bordered" style="color: black;">
        <thead>
          <tr style="background:#CCC">
            <th>Sr No</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Created At</th>
          </tr>
        </thead>
      </table>

      <?php if($mode !== 'banker') { ?>
      <div class="container">
        <div class="col-md-12">

        <button type="button" id="withdraw" class="btn btn-primary">Withdraw</button>
        <button type="button" id="deposit" class="btn btn-secondary">Deposit</button>

        </div>
      </div>
      <?php } else { ?>
        <button class="btn btn-primary" onclick="history.go(-1);">Back </button>
        <?php } ?>

      <!-- Modal for Withdraw - Starts -->
    <div id="myWithdrawModel" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Withdraw Amount</h5>
                    <button type="button" class="closewith" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p><b>Total Amount: <?php echo isset($tot_amt['total_amt']) ? $tot_amt['total_amt'] : 0; ?></b></p>
                    <form id="uploadform" method="POST" enctype="multipart/form-data">
                        <table>
                        <input type="hidden" id="with_mode" name="with_mode" value="Withdraw">
                            <tr><td>Amount: <input type="number" id="withamt" name="withamt" placeholder="Enter Amount"></td></tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn closewith btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="withbtn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Withdraw - End -->

    <!-- Modal for Deposit - Starts -->
    <div id="myDepositModel" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deposit Amount</h5>
                    <button type="button" class="closedep" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p><b>Total Amount: <?php echo isset($tot_amt['total_amt']) ? $tot_amt['total_amt'] : 0; ?></b></p>
                    <form id="uploadform" method="POST" enctype="multipart/form-data">
                        <table>
                        <input type="hidden" id="des_mode" name="des_mode" value="Deposit">
                            <tr><td>Amount: <input type="number" id="despamt" name="despamt" placeholder="Enter Amount"></td></tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn closedep btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="depbtn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Deposit - End -->

    </div>
<script type="text/javascript">
    $(function() {
          var trans_data = $('#trans_list').DataTable({
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
              url: "<?php echo base_url('Account/get_trans_detail') ?>",
              type: "post"
            }
          });
          
        });

        $(document).ready(function(){
            $("#withdraw").click(function(){
                $("#myWithdrawModel").modal('show');
            });

            $(".closewith").click(function(){
                $("#myWithdrawModel").modal('hide');
            });

            $("#deposit").click(function(){
                $("#myDepositModel").modal('show');
            });

            $(".closedep").click(function(){
                $("#myDepositModel").modal('hide');
            });

            $("#depbtn").click(function(e){
                e.preventDefault();

                var amt = $('#despamt').val();
                var mode = $('#des_mode').val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url("Account/deposit_amt"); ?>",
                    dataType: 'json',
                    data: {
                        amti: amt,
                        modei: mode
                    },
                    success: function (res) {
                    var dataResult = JSON.parse(JSON.stringify(res));
                    if (dataResult.status == 200) {
                        window.location.replace("<?php echo base_url('Account/index'); ?>");
                    }
                    else {
                        alert("Enter Correct Amount");
                    }
                    }
                });
            });

            $("#withbtn").click(function(e){
                e.preventDefault();

                var amt = $('#withamt').val();
                var mode = $('#with_mode').val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url("Account/withdraw_amt"); ?>",
                    dataType: 'json',
                    data: {
                        amti: amt,
                        modei: mode
                    },
                    success: function (res) {
                        var dataResult = JSON.parse(JSON.stringify(res));
                        if (dataResult.status == 200) {
                            window.location.replace("<?php echo base_url('Account/index'); ?>");
                        }
                        else {
                            console.log(dataResult.msg);
                            alert(dataResult.msg);
                        }
                    }
                });
            });
    });

</script>

  <p><a style="color: hotpink;" href="<?php echo site_url('Account/logout'); ?>">Log-Out</a></p>
      </div>
</body>
</html>