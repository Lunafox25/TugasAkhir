<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title ?></title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css') ?>">
</head>
<body>
    <div class="container h-100">
        <div class="container">
			<h1 class="text-center"> APLIKASI PENGELOLAAN DATA SITI SAHARA MULYADIN</h1>
            <h3 class="menu text-center"> MENU </h3>
            <div class="row align-items-center h-100">
                <div class="col"> <a href="<?php echo site_url('/jabatan') ?>">Jabatan</a> </div>
                <div class="col"> <a href="<?php echo site_url('/menu') ?>">Data 2</a> </div>
                <div class="col"> <a href="<?php echo site_url('/menu') ?>">Data 3</a> </div>
                <div class="col"> <a href="<?php echo site_url('/berobat') ?>">Data 4 </a></div>
            </div>
			<h3 class="menu text-center"> LAPORAN </h3>
            <div class="row align-items-center h-100">
                <div class="col"> <a href="<?php echo site_url('/menu') ?>">List 1 </a> </div>
                <div class="col"> <a href="<?php echo site_url('/menu') ?>">List 2</a> </div>
                <div class="col"> <a href="<?php echo site_url('/menu') ?>">List 3 </a> </div>  
            </div>
        </div>
    </div>

    <table class="mystyled-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Points</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Dom</td>
            <td>6000</td>
        </tr>
        <tr class="active-row">
            <td>Melissa</td>
            <td>5150</td>
        </tr>
        <!-- and so on... -->
    </tbody>
</table>
    
</body>
</html>