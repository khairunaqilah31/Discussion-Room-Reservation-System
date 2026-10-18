<?php
session_start();
include('dbConfiguration.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// SQL query to fetch rooms
$sql = "SELECT id, roomName, roomCapacity, roomDescription, roomPicture FROM room";
$result = $conn->query($sql);

// Fetch room data
$rooms = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Catalogue</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .container {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .room-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        .room-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .room-card-details {
            padding: 20px;
        }
        .room-card-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #343a40;
        }
        .room-card-capacity,
        .room-card-description {
            margin-bottom: 10px;
            color: #6c757d;
        }
        .room-card a {
            display: inline-block;
            margin-top: 15px;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .room-card a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Room Catalogue</h1>
</div>

<div class="container">
    <div class="room-grid">
        <?php if (!empty($rooms)): ?>
            <?php foreach ($rooms as $room): ?>
                <div class="room-card">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($room['roomPicture']); ?>" alt="<?php echo htmlspecialchars($room['roomName']); ?>">
                    <div class="room-card-details">
                        <div class="room-card-title"><?php echo htmlspecialchars($room['roomName']); ?></div>
                        <div class="room-card-capacity">Capacity: <?php echo htmlspecialchars($room['roomCapacity']); ?></div>
                        <div class="room-card-description"><?php echo htmlspecialchars($room['roomDescription']); ?></div>
                        <a href="userReservationForm.php?id=<?php echo htmlspecialchars($room['id']); ?>">Reserve Now</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No rooms available</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
