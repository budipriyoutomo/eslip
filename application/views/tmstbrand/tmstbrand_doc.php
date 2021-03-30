<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Tmstbrand List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>NamaPT</th>
		<th>Alamat</th>
		<th>Telp</th>
		<th>Logo</th>
		
            </tr><?php
            foreach ($tmstbrand_data as $tmstbrand)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $tmstbrand->namaPT ?></td>
		      <td><?php echo $tmstbrand->alamat ?></td>
		      <td><?php echo $tmstbrand->telp ?></td>
		      <td><?php echo $tmstbrand->logo ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>