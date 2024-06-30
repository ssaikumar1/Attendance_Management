<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
}

.navbar {
  overflow: hidden;
  background-color: #333;
}

.navbar a {
  float: left;
  font-size: 18px;
  color: white;
  text-align: center;
  padding: 14px 46px;
  text-decoration: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 18px;  
  border: none;
  outline: none;
  color: white;
  padding: 14px 46px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: red;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}
table.center {
  margin-left: auto; 
  margin-right: auto;
  margin-top: 30px;
        }

 .btncenter {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
 }      
        
</style>
</head>
<body style="background-color:white;">

<div class="navbar">
<a href="#"><?php echo $roll_number.' - '.$name; ?></a>
<div class="dropdown">
    <a href="<?php echo base_url("Stdnavcontroller/"); ?>" class="dropbtn">Day Wise Summary 
    </a>
  </div>
  <div class="dropdown">
    <a href="<?php echo base_url("Stdnavcontroller/overall_summary"); ?>" class="dropbtn">Overall Summary 
    </a>
  </div>
  <a href="<?=base_url('AuthController/logout')?>">LogOut</a>
</div>

<div class="container">
  <br>
<div class="form-group">
  <input type="date" id="date-select">
  <label id="date-label">Select Date</label>
</div>
<br>
  <h3>Last 10 Days Attendance</h3>
  <?php if($lastTen['count']>0){ ?>
  <table class="table table-dark table-hover table-striped">
    <thead>
      <th>S.no</th>
      <th>Date</th>
      <th>Attendance</th>
    </thead>
    <tbody>
      <?php $i=0; foreach($lastTen['Attendance'] as $day){ $i++;
        ?>
        <tr class="table-<?php echo ($day['status']=='P')?'success':'danger'; ?>">
          <td ><?php echo $i; ?></td>
          <td ><?php echo date("F jS, Y", strtotime($day['date'])); ?></td>
          <td ><?php echo ($day['status']=='P')?'Present':'Absent'; ?></td>
      </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
  <?php } else {
    echo '<p class="text-secondary">No Attendance available</p>';
  } ?>
</div>
<script>
$(document).on('change','#date-select',function(event){
  $.ajax({
      type:"post",
      url:"<?php echo base_url('Stdnavcontroller/certainDate'); ?>",
      data:{'date':$('#date-select').val()},
      success:function(data){
        var data=JSON.parse(data);
        $('#date-label').html(data.data);
      }
    });
});

</script>
</body>
</html>