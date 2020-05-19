<?php

function saveLog($course, $activity, $studytime)
{

    $response = null;

    // loon andmebaasi ühenduse
    $conn = new mysqli(
        $GLOBALS["serverHost"],
        $GLOBALS["serverUserName"],
        $GLOBALS["serverPassword"],
        $GLOBALS["database"]
    );

    // valmistan ette SQL päringu
    // stmt - statement
    $stmt = $conn->prepare("INSERT INTO vr20_studylog (course, activity, studytime) VALUES (?, ?, ?)");

    echo $conn->error;

    // i-integer, s-string, d-decimal
    $stmt->bind_param("sss", $course, $activity, $studytime);

    // kui viga, siis kuva veateade
    if ($stmt->execute()) {
        $response = 1;
    } else {
        $response = 0;
        echo $stmt->error;
    }

    // sulgen päringu ja andmebaasi ühenduse
    $stmt->close();
    $conn->close();

    return $response;

}


function readLog() {

  $response = null;

  // creating connection to db
  $conn = new mysqli(
    $GLOBALS["serverHost"],
    $GLOBALS["serverUserName"],
    $GLOBALS["serverPassword"],
    $GLOBALS["database"]
  );

  // Returns the default character set for the database connection
  // printf("Initial character set: %s\n", $conn->character_set_name());
  // sets the connection charset to utf8
  $conn->set_charset("utf8");

  $stmt = $conn->prepare("SELECT 
                            vr20_studylog.dayadded, 
                            vr20_studylog_courses.CourseName, 
                            vr20_studylog_activities.ActivityName, 
                            vr20_studylog.studytime 
                          FROM ((vr20_studylog 
                          INNER JOIN vr20_studylog_courses ON vr20_studylog.course=vr20_studylog_courses.CourseID)
                          INNER JOIN vr20_studylog_activities ON vr20_studylog.activity=vr20_studylog_activities.ActivityID)
                          ORDER BY vr20_studylog.dayadded 
                          DESC");

  echo $conn->error;
  $stmt->bind_result($dayaddedFromDB, $courseFromDB, $activityFromDB, $studytimeFromDB);
  $stmt->execute();


  while ($stmt->fetch()) {

    // eraldan kuupäeva ja kellaja muutujast $createdFromDB
    $createdDate = substr($dayaddedFromDB, 0, 10);
    $createdTime = substr($dayaddedFromDB, 10);

    // change date format YYYY-MM-DD => DD-MM-YYYY ja replacing "-" -> "."
    $createdDate = date("d-m-Y", strtotime($createdDate));
    $createdDate = str_replace("-",".", $createdDate);

    // converting float number to hours and minutes
    $studytimeFromDB = sprintf('%02d:%02d', (int) $studytimeFromDB, fmod($studytimeFromDB, 1) * 60);

    // building table rows
    $response .= '<tr>';
    $response .= '<td>' . $createdDate . $createdTime . '</td>';
    $response .= '<td>' . $courseFromDB . '</td>';
    $response .= '<td>' . $activityFromDB . '</td>';
    $response .= '<td class="text-center">' . $studytimeFromDB . '</td>';
    $response .= '</tr>';

  }

  if($response == null) {
    $response = '<div class="alert alert-warning text-center" role="alert">
    Õppelogi on tühi. Sisesta midagi ...
  </div>';
  }

  // sulgen päringu ja andmebaasi ühenduse
  $stmt->close();
  $conn->close();

  return $response;
  
}


function getCourses() {

  $response = null;

  // creating connection to db
  $conn = new mysqli(
    $GLOBALS["serverHost"],
    $GLOBALS["serverUserName"],
    $GLOBALS["serverPassword"],
    $GLOBALS["database"]
  );
  
  $stmt = $conn->prepare("SELECT CourseID, CourseName
                          FROM vr20_studylog_courses 
                          ORDER BY CourseID 
                          ASC");

  // sets the connection charset to utf8
  $conn->set_charset("utf8");

  echo $conn->error;
  $stmt->bind_result($courseID, $courseName);
  $stmt->execute();


  while ($stmt->fetch()) {

    // building option values from db to select
    $response .= '<option value="' . $courseID . '">' . $courseName . '</option>';
  }

  if($response == null) {
    $response = '<div class="alert alert-warning text-center" role="alert">
    No Courses available!</div>';
  }

  // sulgen päringu ja andmebaasi ühenduse
  $stmt->close();
  $conn->close();

  return $response;
  
}


function getActivities() {

  $response = null;

  // creating connection to db
  $conn = new mysqli(
    $GLOBALS["serverHost"],
    $GLOBALS["serverUserName"],
    $GLOBALS["serverPassword"],
    $GLOBALS["database"]
  );
  
  $stmt = $conn->prepare("SELECT ActivityID, ActivityName
                          FROM vr20_studylog_activities 
                          ORDER BY ActivityID 
                          ASC");

  // sets the connection charset to utf8
  $conn->set_charset("utf8");
  
  echo $conn->error;
  $stmt->bind_result($activityID, $activityName);
  $stmt->execute();


  while ($stmt->fetch()) {

    // building option values from db to select
    $response .= '<option value="' . $activityID . '">' . $activityName . '</option>';
  }

  if($response == null) {
    $response = '<div class="alert alert-warning text-center" role="alert">
    No Courses available!</div>';
  }

  // sulgen päringu ja andmebaasi ühenduse
  $stmt->close();
  $conn->close();

  return $response;
  
}