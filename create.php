<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_name = $_POST['car_name'];
    $model = $_POST['model'];
    $license_plate = $_POST['license_plate'];
    $rent_per_day = $_POST['rent_per_day'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO cars (car_name, model, license_plate, rent_per_day, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $car_name, $model, $license_plate, $rent_per_day, $status);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Car</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        form { background: #fff; padding: 20px; max-width: 400px; border-radius: 8px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        button { margin-top: 15px; padding: 10px 20px; background: #0984e3; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .back { display: inline-block; margin-bottom: 15px; text-decoration: none; color: #333; }
    </style>
</head>
<body>
    <a class="back" href="index.php">&larr; Back to list</a>
    <h1>Add New Car</h1>
    <form method="POST" action="create.php">
        <label>Car Name</label>
        <input type="text" name="car_name" placeholder="e.g. Toyota Corolla" required>

        <label>Model (Year)</label>
        <input type="text" name="model" placeholder="e.g. 2022" required>

        <label>License Plate</label>
        <input type="text" name="license_plate" placeholder="e.g. LHR-1234" required>

        <label>Rent Per Day (Rs.)</label>
        <input type="number" step="0.01" name="rent_per_day" required>

        <label>Status</label>
        <select name="status" required>
            <option value="Available">Available</option>
            <option value="Rented">Rented</option>
            <option value="Maintenance">Maintenance</option>
        </select>

        <button type="submit">Add Car</button>
    </form>
</body>
</html>
