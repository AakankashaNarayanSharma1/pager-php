<? 
   /*
   ***************************************************************************
   ** THE FOLLOWING CODE USES PROCEDURAL STYLE OF PHP FOR CONNECTION WITH THE DATABASE
   ** USE THE CORRECT VALUES FOR ENTITIES PLACED WITHIN '<>' BEFORE EXEVUTING THE FILE
   ** FOR REST INFORMATION, PLEASE GO THROUGH THE README FILE FOR THE SAME
   ***************************************************************************
   */
?>

<?php $conn = mysqli_connect("localhost", "<username>" , "<password>", "<database name>");

// MORE INFORMATION ABOUT MYSQLI_FUNCTIONS CAN BE FOUND AT 

if($conn)
{
  echo "connected successfully<br />";
}

$rows_per_page = 10;
$sql = "SELECT <columns> FROM <table name> WHERE 1";
$result = mysqli_query($conn,$sql);
$total_records = mysqli_num_rows($result);
$pages = ceil($total_records / $rows_per_page);
echo "pages " . $pages . ", total records : " . $total_records . "<br/>" ;
mysqli_free_result($result);

if (!isset($_GET['screen']))
{
  $screen = 0;
}
else
{
  $screen = $_GET['screen'];
}
$start = $screen * $rows_per_page;
$sql2 = "SELECT <columns> FROM <table name> WHERE 1";
$sql2 .= " LIMIT $start, $rows_per_page";
$result2 = mysqli_query($conn, $sql2);
if($result2)
{
  echo "result set given out <br/><br/> ";
}

$rows = mysqli_num_rows($result2);

while($row = mysqli_fetch_array($result2, MYSQLI_BOTH))
{
  echo "$row : " . $row[0] . "<br/>";
}

echo "<p><hr></p>\n";

// let's create the dynamic links now
if($screen>0)
{
  echo " | <a href=\"test.php\">first</a> | ";
}
if ($screen > 0) {
  $url = "test.php?screen=" . ($screen - 1);
  echo " | <a href=\"$url\">Previous</a> | ";
}

// page numbering links 
$links = 0;
$left = ($screen+1-4);
$right = ($screen+1+4);
if($screen <= 3)
{
  $left = 1;
  $right = 9;
}
elseif($screen > $pages-5)
{
  $right = $pages;
  $left =  $pages - 8;
}

for($i=$left;$i <= $right ;$i++)
{
  $url = "test.php?screen=" . ($i-1);
  if($i==$screen+1)
  {
    echo " ~ <strong><a href=\"$url\">$i</a></strong> ~ ";
  }
  else
  {
  echo " ~ <a href=\"$url\">$i</a> ~ ";
}
}

if ($screen < $pages-1) {
  $url = "test.php?screen=" . ($screen + 1);
  echo " | <a href=\"$url\">Next</a> |";
}
if($screen < $pages-1)
{
  $url = "test.php?screen=" . ($pages-1);
  echo " | <a href=\"$url\">last</a> |";  
}
?>