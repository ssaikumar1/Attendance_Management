<!DOCTYPE html>

<html>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<style>

body {

  font-family: Arial, Helvetica, sans-serif;

}



.navbar4 {

  overflow: hidden;

  background-color: #333;

}



.navbar4 a {

  float: left;

  font-size: 18px;

  color: white;

  text-align: center;

  padding: 14px 46px;

  text-decoration: none;

}



.dropdown4 {

  float: left;

  overflow: hidden;

}



.dropdown4 .dropbtn4 {

  font-size: 18px;  

  border: none;

  outline: none;

  color: white;

  padding: 14px 46px;

  background-color: inherit;

  font-family: inherit;

  margin: 0;

}



.navbar4 a:hover, .dropdown4:hover .dropbtn4 {

  background-color: red;

}



.dropdown-content4 {

  display: none;

  position: absolute;

  background-color: #f9f9f9;

  min-width: 160px;

  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);

  z-index: 1;

}



.dropdown-content4 a {

  float: none;

  color: black;

  padding: 12px 16px;

  text-decoration: none;

  display: block;

  text-align: left;

}



.dropdown-content4 a:hover {

  background-color: #ddd;

}



.dropdown4:hover .dropdown-content4 {

  display: block;

}

table.center {

  margin-left: auto; 

  margin-right: auto;

  margin-top: 30px;

        }



 .btncenter4 {

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

<body style="background-color:white;">



<div class="navbar4">

<a href="<?php echo base_url('NavbarController/'); ?>">Home</a>

  <div class="dropdown4">

    <button class="dropbtn4">Attendance 

      <i class="fa fa-caret-down4"></i>

    </button>

    <div class="dropdown-content4">

      <?php

        foreach($classes as $class){

          ?><a href="<?php echo base_url('NavbarController/index'); ?>?branch=<?php echo $class[1]; ?>&sec=<?php echo $class[2]; ?>&sem=<?php echo $class[3]; ?>"><?php echo strtoupper($class[0]).' '.strtoupper($class[1]).' SEC-'.strtoupper($class[2]); ?></a><?php

        }

      ?>

    </div>

  </div>

  

<div class="dropdown4">

    <button class="dropbtn4">Day Summary 

      <i class="fa fa-caret-down4"></i>

    </button>

    <div class="dropdown-content4">

      <a href="<?=base_url('NavbarController/index2')?>">Absent students</a>

      <a href="<?=base_url('NavbarController/index22')?>">Present Students</a>

    </div>

  </div>
  <a href="<?=base_url('NavbarController/count')?>">OverAll Count</a>


  <a href="<?=base_url('NavbarController/index3')?>">OverAll Summary</a>

  <div class="dropdown4">

<button class="dropbtn4">Std Details

  <i class="fa fa-caret-down4"></i>

</button>

<div class="dropdown-content4">

  <?php

    foreach($classes as $class){

      ?><a href="<?php echo base_url('NavbarController/index'); ?>?branch=<?php echo $class[1]; ?>&sec=<?php echo $class[2]; ?>&sem=<?php echo $class[3]; ?>"><?php echo strtoupper($class[0]).' '.strtoupper($class[1]).' SEC-'.strtoupper($class[2]); ?></a><?php

    }

  ?>

</div>

</div>

  <a href="<?=base_url('AuthController/logout')?>">LogOut</a>

</div>