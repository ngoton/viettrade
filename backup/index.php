<?php
$check = isset($_GET['bk'])?$_GET['bk']:null;
if($check == 'mysql'){
include("connection.php");
function backup_db(){
/* Luu tru tat ca ten Table vao mot mang */
$allTables = array();
$result = mysql_query('SHOW TABLES');
while($row = mysql_fetch_row($result)){
     $allTables[] = $row[0];
}
 $return = "";
foreach($allTables as $table){
$result = mysql_query('SELECT * FROM '.$table);
$num_fields = mysql_num_fields($result);
 
$return.= 'DROP TABLE IF EXISTS '.$table.';';
$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
$return.= "\n\n".$row2[1].";\n\n";
 
for ($i = 0; $i < $num_fields; $i++) {
while($row = mysql_fetch_row($result)){
   $return.= 'INSERT INTO '.$table.' VALUES(';
     for($j=0; $j<$num_fields; $j++){
       $row[$j] = addslashes($row[$j]);
       $row[$j] = str_replace("\n","\\n",$row[$j]);
       if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; }
       else { $return.= '""'; }
       if ($j<($num_fields-1)) { $return.= ','; }
     }
   $return.= ");\n";
}
}
$return.="\n\n";
}
 
// Tao Backup Folder
$folder = 'DB_Backup/';
if (!is_dir($folder))
mkdir($folder, 0777, true);
chmod($folder, 0777);
 
$date = date('m-d-Y-H-i-s', time());
$filename = $folder."db-backup-".$date;
 
$handle = fopen($filename.'.sql','w+');
fwrite($handle,$return);
fclose($handle);

//mở file để đọc với chế độ nhị phân (binary)
$fp = fopen($filename.'.sql', "rb");
 
//gởi header đến cho browser
header('Content-type: application/octet-stream');
header('Content-disposition: attachment; filename="VIETTRADE-'.$filename.'.sql"');
header('Content-length: ' . filesize($filename.'.sql'));
 
//đọc file và trả dữ liệu về cho browser
fpassthru($fp);
fclose($fp);

unlink($filename.'.sql');
 

}
 
// Goi ham thuc thi
backup_db();
}
?>