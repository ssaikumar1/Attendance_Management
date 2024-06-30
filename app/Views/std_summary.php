<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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



<div><br>
    <center>
<form id="internal-form">
  <label for="date">From Date:</label>
  <input type="date" name="date" id="date" required/>
  <label for="date">To Date:</label>
  <input type="date" name="todate" id="todate" required/>
  <input id="internal-sub" style="display:none;" type="submit">
</form><br>
<button id="external-sub" class="btn btn-primary">Submit</button>
</center>

<br><br>
<div class="container" id="std-table">

  </div>
  <script>
$('#external-sub').on('click',function(event){
  var form=document.getElementById('internal-form');
  if(!form.checkValidity()){
    var sbtn=document.getElementById('internal-sub');
    sbtn.click();
  }
  else{
    var data=$('#internal-form').serialize();
    $.ajax({
      type:"post",
      url:"<?php echo base_url('Stdnavcontroller/summary'); ?>",
      data:data,
      success:function(data){
        console.log(data);
        var data=JSON.parse(data);
        console.log(data);
        if(data.nowd>0){
          var table=`<center><h3>No.of Working Days: `+data.nowd+`</h3><h3>No. of Days Present: `+data.pds+`</h3><h3>No. of Days Absent: `+data.ads+`</h3><h3>Attendance Percentage: `+data.percent+`%</h3></center><table class="center table table-striped table-hover table-dark"><thead><th>S.No</th><th>Date</th><th>Attendance</th><tbody>`;
          for(var i=0;i<data.Attendance.length;i++){
            table+=`<tr class="table-`+((data['Attendance'][i]['status']==='P')?`success`:`danger`)+`"><td>`+(i+1)+`</td><td>`+data['Attendance'][i]['date']+`</td><td>`+((data['Attendance'][i]['status']==='P')?`Present`:`Absent`)+`</td></tr>`;
          }
          table+=`</tbody></table>`;
        }
        else{
          var table='<center>NO Working Days Available in this range</center>';
        }
        $('#std-table').html(table);
      }
    });
  }
});
  </script>
   
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>