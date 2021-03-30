

  <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
 <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Import Data
        <small>Report</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Report Schedule </li>
      </ol>
    </section>
<!-- Main content -->
    <section class="content">
	      <div class="row">
        <div class="col-xs-12">


          <div class="box">
            <div class="box-header">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">


              <?php
              echo form_open_multipart($action);

              echo '<div class="form-group">';
              echo '<label>Nama PT' . form_error('namapt') . '</label>';

              echo "<select class='form-control select2' style='width: 100%;' name='namapt' id='namapt' onchange='getbrand(this);'>";
        			echo "<option selected='selected' value=";
        			//echo $namapt->id.">";
        			//if($namapt->id!=null){ echo $namapt->namapt;}else{ echo "";};
        			echo "</option>";



        					foreach($namapt as $row){

        						echo "<option value=";
        						echo $row->id;
        						echo ">";
        						echo $row->namaPT;
        						echo "</option>";

        					}


                           echo "</select >";
              echo '</div>';

              echo '<div class="form-group">';
              echo '<label>Periode Gaji' . form_error('periodegaji') . '</label>'; // show error judul
              echo '<div class="input-group date">';
              echo '<div class="input-group-addon">';
              echo '<i class="fa fa-calendar"></i>';
              echo '</div>';

              $periodegajiform = array(
                    'type'  => 'text',
                    'name'  => 'periodegaji',
                    'id'    => 'periodegaji',
                    'class' => 'form-control pull-right'
              );

              echo form_input($periodegajiform);
              echo '</div>';
              echo '</div>';

              echo '<div class="form-group">';
              echo '<label>Penerbitan Gaji' . form_error('penerbitgaji') . '</label>';
              echo '<div class="input-group date">';
              echo '<div class="input-group-addon">';
              echo '<i class="fa fa-calendar"></i>';
              echo '</div>';

              $penerbitgajiform = array(
                    'type'  => 'text',
                    'name'  => 'penerbitgaji',
                    'id'    => 'penerbitgaji',
                    'class' => 'form-control pull-right'
              );

              echo form_input($penerbitgajiform);
              echo '</div>';

              //echo form_input('penerbitgaji', $penerbitgaji, 'class="form-control pull-right" placeholder="Penerbitan Gaji"');
              echo '</div>';

              echo '<div class="form-group">';
              echo '<label>Browse File  ' . $error . '</label>'; // show error upload
              echo form_upload('userfile');
              echo '</div>';

              echo form_submit('mysubmit', 'Import', 'class="btn btn-primary"');
              echo form_close();
              ?>
