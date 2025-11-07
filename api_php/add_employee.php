<?php


include 'condb.php';

try {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['firstname'], $data['lastname'], $data['phone'], $data['username'], $data['password'])) {
            $stmt = $conn->prepare("INSERT INTO employees (firstname, lastname, phone, username, password) VALUES (:firstName, :lastName, :phone, :username, :password)");
            $stmt->bindParam(':firstname', $data['firstname']);
            $stmt->bindParam(':lastname', $data['lastname']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':username', $data['username']);
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashedPassword);

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