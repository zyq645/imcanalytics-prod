<?php
// Create connection
$con=mysqli_connect("db536766613.db.1and1.com","dbo536766613","IMCsql!s05","db536766613");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
} 

?>

<head>
<style>
th,td {
    text-align: center;
}
</style>
</head>
<body>


<strong>
BASIC SQL SELECT EXAMPLE - CUSTOMERS (Table):</strong>
<p>

<?php

$search1 = mysqli_query($con,"SELECT * FROM `Customer`");
$o = 0;

$arraylist = array();
?>

<table class="display" cellspacing="0" width="100%">
    <thead  style="background-color: #848482; color: #ffffff;" >
		<tr>
          <th>First Name</th>
		  <th>Last Name</th>
		  <th>User ID</th>
		  <th>Customer ID</th> 
		  <th>Days Since Last Visit</th>
		  <th>Genre Preference</th>
		  <th>Number of Purchases</th>
		  <th>Total Purchase Value</th>
		  <th>Days Since Last Purchase</th>
		  <th>Items in Cart</th>
		  <th>Latest Item Added</th>
		</tr> 
    </thead>	

 <?php
while($row = mysqli_fetch_array($search1)) {
 echo '<tr>';
  echo '<td>' . $row['First'] . '</td>';
  echo '<td>' . $row['Last'] . '</td>';
  echo '<td>' . $row['UID'] . '</td>';
  echo '<td>' . $row['Cust_id'] . '</td>';
  echo '<td>' . $row['VisitDays'] . '</td>';
  echo '<td>' . $row['Pref'] . '</td>';
  echo '<td>' . $row['PurchNum'] . '</td>';
  echo '<td>' . $row['PurchTot'] . '</td>';
  echo '<td>' . $row['PurchDays'] . '</td>';
  echo '<td>' . $row['CartItems'] . '</td>';
  echo '<td>' . $row['LastCart'] . '</td>';
 echo '</tr>';
 $o++;
 } 
 ?>
 
</table>

<p>
<strong>WHERE EXAMPLE - GENRE PREFERENCE = 1</strong>
<p>

<?php
$sql = "SELECT * FROM Customer WHERE Pref = 1";
$search2 = mysqli_query($con,$sql);
$o = 0;

$arraylist = array();

?>

<table class="display" cellspacing="0" width="100%">
    <thead  style="background-color: #848482; color: #ffffff;" >
		<tr>
		  <th>Last Name</th>
		  <th>Number of Purchases</th>
		</tr> 
    </thead>	

 <?php
while($row = mysqli_fetch_array($search2)) {
 echo '<tr>';

  echo '<td>' . $row['Last'] . '</td>';
  echo '<td>' . $row['PurchNum'] . '</td>';

 echo '</tr>';
 $o++;
 } 
 ?>
 
</table>

<p>
<strong>JOIN EXAMPLE - LAST TOUCH CHANNEL</strong>
<p>

<?php
$sql = "SELECT Customer.Last, Media.CHAN_NAME FROM Customer INNER JOIN Media ON Customer.LastClick = Media.CHAN_ID";
$search3 = mysqli_query($con,$sql);
$o = 0;

$arraylist = array();

?>

<table class="display" cellspacing="0" width="100%">
    <thead  style="background-color: #848482; color: #ffffff;" >
		<tr>
		  <th>Last Name</th>
		  <th>Last Referring Channel</th>
		</tr> 
    </thead>	

 <?php
while($row = mysqli_fetch_array($search3)) {
 echo '<tr>';

  echo '<td>' . $row['Last'] . '</td>';
  echo '<td>' . $row['CHAN_NAME'] . '</td>';

 echo '</tr>';
 $o++;
 } 
 ?>
 
</table>

<p>
<strong>WHERE ASSIGNMENT - NUMBER OF PURCHASES > 2 </strong>
<p>

 
 <?php
$sql = "SELECT * FROM Customer WHERE PurchNum > 2";
$search4 = mysqli_query($con,$sql);
$o = 0;

$arraylist = array();

?>
 
<table class="display" cellspacing="0" width="100%">
    <thead  style="background-color: #848482; color: #ffffff;" >
		<tr>
		  <th>Last Name</th>
		  <th>Number of Purchases</th>
		</tr> 
    </thead>	

 <?php
//STUDENT COMMENT: I don't really understand what $arraylist means here and what echo and $o++ means here
while($row = mysqli_fetch_array($search4)) {
echo '<tr>';

  echo '<td>' . $row['Last'] . '</td>';
  echo '<td>' . $row['PurchNum'] . '</td>';

 echo '</tr>';
 $o++;
 } 
?>
 
</table>

<p>
<strong>JOIN ASSIGNMENT - TITLE OF LATEST ITEM ADDED</strong>
<p>

<?php
$sql = "SELECT Customer.Last, Bookdetails.Title FROM Customer INNER JOIN Bookdetails 
ON Customer.LastCart = Bookdetails.bid";
$search5 = mysqli_query($con,$sql);
$o = 0;

$arraylist = array();

?>


<table class="display" cellspacing="0" width="100%">
    <thead  style="background-color: #848482; color: #ffffff;" >
		<tr>
		  <th>Last Name</th>
		  <th>Last Title Added</th>
		</tr> 
    </thead>	



 <?php
 //STUDENT COMMENT: 
//$search5 = 
 
while($row = mysqli_fetch_array($search5)) {
echo '<tr>';

echo '<td>' . $row['Last'] . '</td>';
echo '<td>' . $row['Title'] . '</td>';

echo '</tr>';
$o++;
 } 
 ?>
 
</table>

<p>
<strong>ARRAY ASSIGNMENT</strong>
<p>

 <?php
//STUDENT COMMENT:  what mysqli_fetch_array means

$search1 = mysqli_query($con,"SELECT * FROM `Customer`");

while($row = mysqli_fetch_array($search1)) {
//STUDENT COMMENT:
$arraylist[$o][First] = $row['First'];
$arraylist[$o][Last] = $row['Last'];
$arraylist[$o][Cust_id] = $row['Cust_id'];
$arraylist[$o][VisitDays] = $row['VisitDays'];
$arraylist[$o][Pref] = $row['Pref'];
$arraylist[$o][PurchNum] = $row['PurchNum'];
$arraylist[$o][PurchTot] = $row['PurchTot'];
$arraylist[$o][PurchDays] = $row['PurchDays'];
$arraylist[$o][CartItems] = $row['CartItems'];
$arraylist[$o][LastCart] = $row['LastCart'];

 $o++;
} 
?>
 
</table>

<p><strong>CUSTOMERS (Array):</strong><p>
<?php  

mysqli_close($con);

  echo "<pre>";
  
//STUDENT COMMENT:
  print_r($arraylist);
  

?>
<div>
<p>STUDENT QUESTION - WHY/WHEN USE ARRAY INSTEAD OF TABLE?:  
Array is static and stored in local environment an. It is kinda like indexed. So it is really useful
and quick for us when we know the position of an element and we want to access or change 
the element. Tables are more useful when you need to relate two values. For example, if we want
the item purchased by customer with customer_id xxxx, table is faster just like the inner 
join assignment that we have doned.</p>
</div>
</body>

