<!DOCTYPE html>
<html lang="en">
<?php
require  'database.php';
	 if(isset($_POST['buttonimport']))
		 {
			copy($_FILES['jsonfile']['tmp_name'], 'json/'.$_FILES['jsonfile']['name']);
			$data = file_get_contents('json/'.$_FILES['jsonfile']['name']);
			$array = json_decode($data, true);
			foreach ($array as $row) 
			{
				$sql = "INSERT into event(employee_name, employee_mail, event_id, event_name, participation_fee, event_date) Values('".$row['employee_name']."', '".$row['employee_mail']."', '".$row['event_id']."', '".$row['event_name']."', '".$row['participation_fee']."', '".$row['event_date']."')";
				mysqli_query($connect, $sql);
			} 
		} 
		
/*---------Search Filter ----------*/
		
if(isset($_POST['search']))
{

  $valueToName = $_POST['valueToName'];
  $valueToEventname = $_POST['valueToEventname'];
  $valueToEventdate = $_POST['valueToEventdate'];
/*----Query-----*/
   $query = "SELECT * From event WHERE employee_name = '$valueToName' OR event_name = '$valueToEventname' OR event_date = '$valueToEventdate' ";
   $search_result = filterTable($query);
   $rows_count_value = mysqli_num_rows($search_result);
}
 else {
  $query = "SELECT * FROM `event`";
  $search_result = filterTable($query);
  $rows_count_value = mysqli_num_rows($search_result);
  
}

// function to connect with Mysql database and execute
function filterTable($query)
{
  $connect = mysqli_connect("localhost", "root", "", "test_task");
  $filter_Result = mysqli_query($connect, $query);
  return $filter_Result;
}		
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Code Challenge(Event) Task</title>
</head>
<style>
         table, th, td {
            border: 1px solid black;
         }
      </style>
<body>
  <div id="main">
    <div id="header">
      <h1>Code Challenge(Event) Task</h1>
    </div>
	<div>
	<h4>Import JSON File</h4>
	<form method="post" enctype="multipart/form-data">
	<input type="file" name="jsonfile"/>
	</br>
	</br>
	<input type="submit" value="Import" name="buttonimport">
	</form>
	</div>
	</br>
	<h3> Search Filter</h3>
    <form action="index.php" method="post">

      <input type="text" name="valueToName" placeholder="Value To Employee Name">
      <input type="text" name="valueToEventname" placeholder="Value To Event Name">
      <input type="date" name="valueToEventdate" placeholder="Value To Event Date">
      <input type="submit" name="search" value="Filter"><br><br>
      <table>
        <tr>
          <th>Participation ID</th>
         <th>Employee Name</th>
         <th>Employee mail</th>
         <th>Event ID</th>
         <th>Event Name</th>
         <th>Participation Fee</th>
         <th>Event Date</th>
        </tr>
		<?php while($row = mysqli_fetch_array($search_result)):?>
			<tr>
				<td><?php echo $row['participation_id']?></td>
				<td><?php echo $row['employee_name']?></td>
				<td><?php echo $row['employee_mail']?></td>
				<td><?php echo $row['event_id']?></td>
				<td><?php echo $row['event_name']?></td>
				<td><?php echo $row['participation_fee']?></td>
				<td><?php echo $row['event_date']?></td>
			</tr>
		<?php endwhile;?>
				<tr>
					
					<td>No. of entries <?php echo $rows_count_value;?></td>
				</tr>
			</table>
		</form> 
    </div>
  </div>

</body>
</html>
