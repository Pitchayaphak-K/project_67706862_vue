    echo json_encode(["success" => false, "message" => $e->getMessage()]);_id, firstName, lastName, phone, username FROM customers ORDER BY customer_id DESC");
<?php
// เชื่อมต่อฐานข้อมูล
include 'condb.php';

header("Content-Type: application/json; charset=UTF-8");

try {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === "GET") {
        // ✅ ดึงข้อมูลลูกค้าทั้งหมด
        $stmt = $conn->prepare("SELECT employee_id, firstname, lastname, phone, username FROM employees ORDER BY employee_id DESC");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "data" => $result]);
    }

    elseif ($method === "DELETE") {
        // ✅ ลบข้อมูลลูกค้าตาม customer_id
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["employee_id"])) {
            echo json_encode(["success" => false, "message" => "ไม่พบค่า customer_id"]);
            exit;
        }

        $customer_id = intval($data["employee_id"]);

        $stmt = $conn->prepare("DELETE FROM employees WHERE employee_id = :id");
        $stmt->bindParam(":id", $employee_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "ลบข้อมูลเรียบร้อย"]);
        } else {
            echo json_encode(["success" => false, "message" => "ไม่สามารถลบข้อมูลได้"]);
        }
    }

    else {
        echo json_encode(["success" => false, "message" => "Method ไม่ถูกต้อง"]);
    }

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}