foreach($data as $row){

mysqli_query($conn,"INSERT INTO projects
(student_name,roll_no,batch_year,project_title)
VALUES('$row[0]','$row[1]','$row[2]','$row[3]')");

}
