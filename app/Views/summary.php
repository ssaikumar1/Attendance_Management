<!DOCTYPE html>

<html>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<style>



body {

            font-family: sans-serif;

        }



        h1 {

            text-align: center;

        }



        form {

            width: 50%;

            margin: 0 auto;

        }



        label {

            font-weight: bold;

        }



        select {

            width: 100%;

        }



        input[type="date"] {

            width: 100%;

        }



        button {

            width: 100%;

            margin-top: 20px;

        }



        #std-table {

            width: 100%;

            border-collapse: collapse;

            margin-top: 20px;

        }



        #std-table th, #std-table td {

            border: 1px solid black;

            padding: 10px;

        }



        /* Custom CSS for Bootstrap */



        .center {

            text-align: center;

        }



        /* Responsive CSS */



        @media screen and (max-width: 768px) {

            form {

                width: 100%;

            }

        }

        table.center {

  margin-left: auto; 

  margin-right: auto;

        }

        #internal-form {

  margin-top: 30px;

}



        

  </style>

  <style>

body {

  font-family: Arial, Helvetica, sans-serif;

}



.navbar3 {

  overflow: hidden;

  background-color: #333;

}



.navbar3 a {

  float: left;

  font-size: 18px;

  color: white;

  text-align: center;

  padding: 14px 46px;

  text-decoration: none;

}



.dropdown3 {

  float: left;

  overflow: hidden;

}



.dropdown3 .dropbtn3 {

  font-size: 18px;  

  border: none;

  outline: none;

  color: white;

  padding: 14px 46px;

  background-color: inherit;

  font-family: inherit;

  margin: 0;

}



.navbar3 a:hover, .dropdown3:hover .dropbtn3 {

  background-color: red;

}



.dropdown-content3 {

  display: none;

  position: absolute;

  background-color: #f9f9f9;

  min-width: 160px;

  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);

  z-index: 1;

}



.dropdown-content3 a {

  float: none;

  color: black;

  padding: 12px 16px;

  text-decoration: none;

  display: block;

  text-align: left;

}



.dropdown-content3 a:hover {

  background-color: #ddd;

}



.dropdown3:hover .dropdown-content3 {

  display: block;

}

table.center {

  margin-left: auto; 

  margin-right: auto;

  margin-top: 30px;

        }



 .btncenter3 {

  display: flex;

  justify-content: center;

  align-items: center;

  margin-top: 20px;

 }

 table {

  border-collapse: collapse;

  width: 100%;

}



th, td {

  text-align: center;

  padding: 8px;

}



thead {

  background-color: #f2f2f2;

}



tr:hover {

  background-color: #ddd;

}



.center {

  margin: 0 auto;

  width: 50%;

}

.form-check-input {

  height: 1rem;

  width: 1rem;

}







      

        

</style>

</head>

<body>

<div class="navbar3">

<a href="<?= base_url('NavbarController') ?>">Home</a>

  <div class="dropdown3">

    <button class="dropbtn3">Attendance 

      <i class="fa fa-caret-down3"></i>

    </button>

    <div class="dropdown-content3">

      <?php

        foreach($classes as $class){

          ?><a href="<?php echo base_url('NavbarController/index'); ?>?branch=<?php echo $class[1]; ?>&sec=<?php echo $class[2]; ?>&sem=<?php echo $class[3]; ?>"><?php echo strtoupper($class[0]).' '.strtoupper($class[1]).' SEC-'.strtoupper($class[2]); ?></a><?php

        }

      ?>

    </div>

  </div>

  

<div class="dropdown3">

    <button class="dropbtn3">Day Summary 

      <i class="fa fa-caret-down3"></i>

    </button>

    <div class="dropdown-content3">

      <a href="<?=base_url('NavbarController/index2')?>">Absent students</a>

      <a href="<?=base_url('NavbarController/index22')?>">Present Students</a>

    </div>

  </div>

  

  
  <a href="<?=base_url('NavbarController/count')?>">OverAll Count</a>

  <a href="<?=base_url('NavbarController/index3')?>">OverAll Summary</a>

  <div class="dropdown3">

<button class="dropbtn3">Std Details

  <i class="fa fa-caret-down3"></i>

</button>

<div class="dropdown-content3">

  <?php

    foreach($classes as $class){

      ?><a href="<?php echo base_url('NavbarController/index'); ?>?branch=<?php echo $class[1]; ?>&sec=<?php echo $class[2]; ?>&sem=<?php echo $class[3]; ?>"><?php echo strtoupper($class[0]).' '.strtoupper($class[1]).' SEC-'.strtoupper($class[2]); ?></a><?php

    }

  ?>

</div>

</div>

  <a href="<?=base_url('AuthController/logout')?>">LogOut</a>

</div>









<div>

<form id="internal-form">

    <label for="class">Class:</label>
      <select name="class" id="class"required>
        <option value="">Select Class</option>
        <?php foreach($classes as $class){
          ?>
            <option value="<?php echo $class[1].'-'.$class[2].'-'.$class[3]; ?>"><?php echo $class[0]." ".$class[1]." SEC-".$class[2]; ?></option>
          <?php
        }

        ?>
      </select>

  <label for="date">From Date:</label>

  <input type="date" name="date" id="date" required/>

  <label for="date">To Date:</label>

  <input type="date" name="todate" id="todate" required/>





  <input id="internal-sub" style="display:none;" type="submit">

  

</form>

<button id="external-sub" class="btn btn-primary">Submit</button>

<br><br>

<div id="std-table">



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

      url:"<?php echo base_url('NavbarController/summary'); ?>",

      data:data,

      success:function(data){

        console.log(data);

        var data=JSON.parse(data);

        console.log(data);

        if(data.nowd>0){

          var table=`<center><h3>No.of Working Days: `+data.nowd+`</h3></center><table class="center"><thead><th>S.No</th><th>Roll No</th><th class="text-start">Name</th><th>Present Days</th><th>Percentage</th><tbody>`;

          for(var i=0;i<data.students.length;i++){

            table+=`<tr><td>`+(i+1)+`</td><td>`+data['students'][i]['roll_number']+`</td><td class="text-start">`+data['students'][i]['name']+`</td><td>`+data['students'][i]['pds']+`</td><td>`+data['students'][i]['percent']+`</td></tr>`;

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