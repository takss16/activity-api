<?php
    // Set headers to allow cross-origin requests
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json');

    $conn = mysqli_connect("localhost","root","","student_db");

    if(!$conn){
        die("Connection Error");
    }

    $query = "select * from students";
    $result = mysqli_query($conn,$query);

    $method = $_SERVER['REQUEST_METHOD'];
    if(mysqli_num_rows($result) > 0){
        while($show = mysqli_fetch_assoc($result)){
            $data[] = $show;
        }
    }else{
        echo "No Record Found!";
    }
    

    if($method == "GET") {        
        if(isset($_GET['id'])) {
            if(isset($data[$_GET['id']]))
                echo json_encode($data[$_GET['id']]);
            else
                echo json_encode('No Record Found!');
        }
        else
        if(isset($data)){
            echo json_encode($data);
        }
    }

    if($method == "POST") {
        $temp = urldecode(file_get_contents('php://input'));
        parse_str($temp, $value);

       
        $name = $value['name'];
        $course = $value['course'];
        $address = $value['address'];
        $query = "INSERT INTO students(name,course,address) VALUES ('$name','$course','$address')";
        $add = mysqli_query($conn,$query);
        $response = [
            "message" => "Post Success",
            "data" => $data
        ];
        echo json_encode($response);
    }

    if($method == "PUT") {
        $temp = urldecode(file_get_contents('php://input'));
        parse_str($temp, $value);
        
        $id = $value['id'];
        $name = $value['name'];
        $course = $value['course'];
        $address = $value['address'];
        $query = "UPDATE students SET name = '$name', course = '$course',address = '$address' WHERE id = '$id'";
        $update = mysqli_query($conn,$query);

        

        $response = [
            "message" => "Put Success",
            "data" => $data
        ];
        echo json_encode($response); 
    }

    if($method == "DELETE") {
        $temp = urldecode(file_get_contents('php://input'));
        parse_str($temp, $value);
        $id = $value['id'];
        $query = "DELETE FROM students WHERE id = '$id'";
        $deletes = mysqli_query($conn,$query);
        $response = [
            "message" => "Delete Success",
            "data" => $data
        ];
        echo json_encode($response);
    }


?>