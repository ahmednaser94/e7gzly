<?php
require_once 'header.php';

if ($_SESSION['logged'] != 1)
	header('Location: ../index.php');
else if ($_SESSION['logged'] && (!$_SESSION['user_type'] > 1 && !$_SESSION['user_type'] < 5))
	header('Location: ../denied.php');
?>

<!-- Employee Dashboard -->

<?php if ($_SESSION['user_type'] == 2) : ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<div class="card gradient-3">
					<div class="card-body">
						<h3 class=" text-white">Waiting Customers</h3>
						<div class="d-inline-block">
							<h2 id='waiting' class="text-white"></h2>
						</div>
						<span class="float-right display-5 opacity-5"><i class="fas fa-user-clock"></i></span>
					</div>
				</div>
			</div>
			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<div class="card gradient-1">
					<div class="card-body">
						<h3 class="text-white">Customer Name</h3>
						<div class="d-inline-block">
							<h2 id='cust_name' class="text-white"></h2>
						</div>
						<span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
					</div>
				</div>
			</div>
			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<div class="card gradient-2">
					<div class="card-body">
						<h3 class=" text-white">Service Name</h3>
						<div class="d-inline-block">
							<h2 id='service_name' class="text-white"></h2>
						</div>
						<span class="float-right display-5 opacity-5"><i class="fas fa-cogs"></i></span>
					</div>
				</div>
			</div>

			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<div class="card gradient-4">
					<div class="card-body">
						<h3 class="text-white">Ticket Number</h3>
						<div class="d-inline-block">
							<h2 id='ticket_name' class="text-white"></h2>
						</div>
						<span class="float-right display-5 opacity-5"><i class="fas fa-ticket-alt"></i></span>
					</div>
				</div>
			</div>
		</div>
		<div class="row py-5">
			<div class="col-12">
				<form id="next_customer_form" method="post">
					<button id="next_button" name="form-btn" value="next" class="btn btn-primary form-btn d-block mx-auto  py-5 px-5 font-size-30" type="submit">
						<h3 class="text-white">Next Customer</h3>
					</button>
				</form>

			</div>
		</div>
	</div>

<?php endif ?>

<?php if ($_SESSION['user_type'] == 3) : ?>
	<div class="container-fluid">
		<div class="row">

			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<a href="employees_list.php">
					<div class="card gradient-1">
						<div class="card-body">
							<h3 class="text-white">Employees Count</h3>
							<div class="d-inline-block">
								<h2 id='emp_ecount' class="text-white"></h2>
							</div>
							<span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<a href="service_emp.php">
					<div class="card gradient-2">
						<div class="card-body">
							<h3 class=" text-white">Serving Emloyees</h3>
							<div class="d-inline-block">
								<h2 id='serving_emp' class="text-white"></h2>
							</div>
							<span class="float-right display-5 opacity-5"><i class="fas fa-hands-helping"></i></span>
						</div>
					</div>
				</a>
			</div>

			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<a href="br_services.php">
					<div class="card gradient-4">
						<div class="card-body">
							<h3 class="text-white">Branch Services</h3>
							<div class="d-inline-block">
								<h2 id='br_services' class="text-white"></h2>
							</div>
							<span class="float-right display-5 opacity-5"><i class="fas fa-cogs"></i></span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<a href="br_services.php">
					<div class="card gradient-3">
						<div class="card-body">
							<h3 class="text-white">Waiting Customers</h3>
							<div class="d-inline-block">
								<h2 id='waiting' class="text-white"></h2>
							</div>
							<span class="float-right display-5 opacity-5"><i class="fas fa-user-clock"></i></span>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>

<?php endif ?>



<?php if ($_SESSION['user_type'] == 4) : ?>
	<div class="container-fluid">
		<div class="row">

			<div id="employees_count" class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Employees and Managers</h4>
						<div id="flotPie1" class="flot-chart"></div>
					</div>
				</div>
			</div>
			<div id="employees_in_service" class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Serving Employees</h4>
						<div id="flotPie2" class="flot-chart"></div>
					</div>
				</div>
			</div>


			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<a href="branches.php">
					<div class="card gradient-3">
						<div class="card-body">
							<h3 class="text-white">Branches Count</h3>
							<div class="d-inline-block">
								<h2 id='br_count' class="text-white"></h2>
							</div>
							<span class="float-right display-5 opacity-5"> <i class="fas fa-code-branch"></i></span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<a href="employees_list.php">
					<div class="card gradient-7 ">
						<div class="card-body">
							<h4 class=" text-white">Total Emloyees &nbsp;
								<span id="total_emp" class="text-white"></span>
							</h4>
							<br>
							<div class="d-inline-block">
								<h4 class=" text-white">Managers Count &nbsp;
									<span id='managers_count' class="text-white"></span>
								</h4>
								<h4 class=" text-white">Emloyees Count &nbsp;
								<span id="emp_count" class="text-white"></span>
								</h4>
							</div>
							<span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
						</div>
					</div>
				</a>
			</div>

			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<a href="employee_approval.php">
					<div class="card gradient-8 ">
						<div class="card-body">
							<h3 class="text-white">Pending Employees</h3>
							<div class="d-inline-block">
								<h2 id='pending_emp' class="text-white"></h2>
							</div>
							<span class="float-right display-5 opacity-5"><i class="fas fa-user-edit"></i></span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<div class="card gradient-2 ">
					<div class="card-body">
						<h3 class="text-white">Serving Employees</h3>
						<div class="d-inline-block">
							<h2 id='serving_emp' class="text-white"></h2>
						</div>
						<span class="float-right display-5 opacity-5"><i class="fas fa-hands-helping"></i></span>
					</div>
				</div>
			</div>
			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<a href="services_org.php">
					<div class="card gradient-4 ">
						<div class="card-body">
							<h3 class="text-white">Services Count</h3>
							<div class="d-inline-block">
								<h2 id='serv_count' class="text-white"></h2>
							</div>
							<span class="float-right display-5 opacity-5"><i class="fas fa-cogs"></i></span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-4 offset-lg-1 col-sm-6">
				<div class="card gradient-1 ">
					<div class="card-body">
						<h3 class="text-white">Waiting Customers</h3>
						<div class="d-inline-block">
							<h2 id='waiting' class="text-white"></h2>
						</div>
						<span class="float-right display-5 opacity-5"><i class="fas fa-user-clock"></i></span>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php endif ?>
<?php require_once 'footer.php'; ?>