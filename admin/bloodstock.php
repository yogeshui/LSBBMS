<?php
session_start();
error_reporting(0);
include('include/connection.php');
if(strlen($_SESSION['alogin'])==0)
	{
header('location:index.php');
}
else{
	if(isset($_REQUEST['hidden']))
		{
	$eid=intval($_GET['hidden']);
	$status="2";
	$sql = "UPDATE blood_stock SET Status=:status WHERE ID=:eid";
	$query = $dbh->prepare($sql);
	$query -> bindParam(':status',$status, PDO::PARAM_STR);
	$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
	$query -> execute();

	$msg="Blood Stock Hidden Successfully";
	}


	if(isset($_REQUEST['public']))
		{
	$aeid=intval($_GET['public']);
	$status=1;

	$sql = "UPDATE blood_stock SET Status=:status WHERE ID=:aeid";
	$query = $dbh->prepare($sql);
	$query -> bindParam(':status',$status, PDO::PARAM_STR);
	$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
	$query -> execute();

	$msg="Blood Stock public Successfully";
	}
	if(isset($_REQUEST['del']))
		{
	$did=intval($_GET['del']);
	$sql = "DELETE from blood_stock WHERE ID=:did";
	$query = $dbh->prepare($sql);
	$query-> bindParam(':did',$did, PDO::PARAM_STR);
	$query -> execute();

	$msg="Blood Stock deleted Successfully ";
	}

 ?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">

	<title>Admin Dashboard | Life Source Blood Bank System</title>

	<!-- Font awesome -->
	<link href="../css/all.css" rel="stylesheet">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/css/bootstrap-select.min.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/awesome-bootstrap-checkbox/1.0.2/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style_dashboard.css">

	<!--favicon link-->
	<link rel="apple-touch-icon" sizes="180x180" href="../images/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../images/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../images/favicon/favicon-16x16.png">
	<link rel="manifest" href="../images/favicon/site.webmanifest">
	<link rel="mask-icon" href="../images/favicon/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">

  <style>
	.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
	}
	.succWrap{
		padding: 10px;
		margin: 0 0 20px 0;
		background: #fff;
		border-left: 4px solid #5cb85c;
		-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
		box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
	}

  .bglabel {
    color: #ef233b;
    font-weight: 400;
  }
	</style>
</head>

<body>
  <?php include('include/header.php');?>

	<div class="ts-main-content">
		<?php include('include/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Blood Stock</h2>

						<!-- Zero Configuration Table -->
						<div class="card">
							<div class="card-header">Blood Stock List</div>
							<div class="card-body">
							<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
				          else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                <div class="table-responsive">
                <table id="zctb" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Blood Bank ID</th>
											<th>Blood Bank</th>
		                  <th>Contact</th>
		                  <th>Category</th>
		                  <th>Availability(Units)</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>#</th>
											<th>Blood Bank ID</th>
											<th>Blood Bank</th>
		                  <th>Contact</th>
		                  <th>Category</th>
		                  <th>Availability(Units)</th>
											<th>Action</th>
										</tr>
									</tfoot>
									<tbody>

                  <?php $sql = "SELECT * from blood_stock ORDER BY ID";
                  $query = $dbh -> prepare($sql);
                  $query->execute();
                  $results=$query->fetchAll(PDO::FETCH_OBJ);
                  $cnt=1;
                  if($query->rowCount() > 0)
                  {
                  foreach($results as $result)
                  {				?>
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($result->BB_ID);?></td>
											<td><?php echo htmlentities($result->info1);?></td>
											<td><?php echo htmlentities($result->info2);?></td>
											<td><?php echo htmlentities($result->info3);?></td>
											<td style="font-weight: bold;">
		                    <span class="bglabel">A+:</span> <?php echo htmlentities($result->Aptve); ?> <span class="bglabel">B+:</span> <?php echo htmlentities($result->Bptve); ?>
		                    <span class="bglabel">O+:</span> <?php echo htmlentities($result->Optve); ?> <span class="bglabel">A-:</span> <?php echo htmlentities($result->Antve); ?>
		                    <span class="bglabel">B-:</span> <?php echo htmlentities($result->Bntve); ?> <span class="bglabel">O-:</span> <?php echo htmlentities($result->Ontve); ?>
		                    <span class="bglabel">AB+:</span> <?php echo htmlentities($result->ABptve); ?> <span class="bglabel">AB-:</span> <?php echo htmlentities($result->ABntve); ?>
		                  </td>

										<td>
											<?php if($result->status==1)
											{?>

											<a href="bb-list.php?hidden=<?php echo htmlentities($result->ID);?>" onclick="return confirm('Do you really want to hiidden this detail')" class="btn btn-primary btn-sm mb-2">Hidden</a><br />
											<?php } else {?>

											<a href="bb-list.php?public=<?php echo htmlentities($result->ID);?>" onclick="return confirm('Do you really want to Public this detail')" class="btn btn-success btn-sm mb-2">Public</a><br />

											<?php } ?>
											<a href="bb-list.php?del=<?php echo htmlentities($result->ID);?>" onclick="return confirm('Do you really want to delete this record')" class="btn btn-danger btn-sm">Delete</a>
											</td>

										</tr>
										<?php $cnt=$cnt+1; }} ?>

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/js/fileinput.min.js"></script>
	<script src="js/main.js"></script>

</body>
</html>
<?php } ?>
