<?php

//error_reporting(E_ALL); ini_set('display_errors', 1);

$search = json_decode($_POST['search']);
$search1 = "%".$search[0]."%";
$search2 = "%".$search[1]."%";
$sql = new mysqli("cse.unl.edu", "apages", "Wtpt4R", "apages");

$qry = "SELECT c.title, c.description, c.prerequisite, c.creditHours, c.courseNum, s.subjectId, a1.aceNum, a2.aceNum ".
        "FROM Course c JOIN Subject s ON c.subject_fk = s.subject_key ".
        "LEFT JOIN Ace AS a1 ON c.ace_1_fk = a1.ace_key ".
        "LEFT JOIN Ace AS a2 ON c.ace_2_fk = a2.ace_key ".
        "WHERE UPPER(s.subjectId) LIKE UPPER(?) AND c.courseNum LIKE ?";
$qry = $sql->prepare($qry);
$qry->bind_param('ss', $search1, $search2);

$qry->execute();
$result = $qry->get_result();

$sql->close();

while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = array(
        'title' => $row['title'],
        'description' => $row['description'],
        'prerequisite' => $row['prerequisite'],
        'creditHours' => $row['creditHours'],
        'courseNum' => $row['courseNum'],
        'courseName' => $row['subjectId'],
        'ace1' => $row['a1.aceNum'],
        'ace2' => $row['a2.aceNum']
    );
}

echo json_encode($rows);
?>
