<?php

include 'condb.php';

try {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['first_name'], $data['last_name'], $data['email'], $data['phone'])) {
            $stmt = $conn->prepare("INSERT INTO students (first_name, last_name, email, phone) VALUES (:first_name, :last_name, :email, :phone)");
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);

            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "ลงทะเบียนสำเร็จ"]);
            } else {
                echo json_encode(["success" => false, "message" => "เกิดข้อผิดพลาดในการบันทึก"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Method not allowed"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
?>