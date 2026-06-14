<?php
include 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_name = $_POST['car_name'];
    $model = $_POST['model'];
    $license_plate = $_POST['license_plate'];
    $rent_per_day = $_POST['rent_per_day'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE cars SET car_name = ?, model = ?, license_plate = ?, rent_per_day = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssdsi", $car_name, $model, $license_plate, $rent_per_day, $status, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    exit();
}

// Fetch existing car data
$stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Car not found.";
    exit();
}

$car = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Car</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        form { background: #fff; padding: 20px; max-width: 400px; border-radius: 8px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        button { margin-top: 15px; padding: 10px 20px; background: #2196F3; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .back { display: inline-block; margin-bottom: 15px; text-decoration: none; color: #333; }
    </style>
</head>
<body>
    <a class="back" href="index.php">&larr; Back to list</a>
    <h1>Edit Car</h1>
    <form method="POST" action="edit.php?id=<?php echo $car['id']; ?>">
        <label>Car Name</label>
        <input type="text" name="car_name" value="<?php echo htmlspecialchars($car['car_name']); ?>" required>

        <label>Model (Year)</label>
        <input type="text" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required>

        <label>License Plate</label>
        <input type="text" name="license_plate" value="<?php echo htmlspecialchars($car['license_plate']); ?>" required>

        <label>Rent Per Day (Rs.)</label>
        <input type="number" step="0.01" name="rent_per_day" value="<?php echo $car['rent_per_day']; ?>" required>

        <label>Status</label>
        <select name="status" required>
            <option value="Available" <?php if ($car['status'] == 'Available') echo 'selected'; ?>>Available</option>
            <option value="Rented" <?php if ($car['status'] == 'Rented') echo 'selected'; ?>>Rented</option>
            <option value="Maintenance" <?php if ($car['status'] == 'Maintenance') echo 'selected'; ?>>Maintenance</option>
        </select>

        <button type="submit">Update Car</button>
    </form>
</body>
</html>
<?php $stmt->close(); $conn->close(); ?>
