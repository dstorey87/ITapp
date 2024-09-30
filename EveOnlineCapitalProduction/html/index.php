<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVE Online Corporation Details</title>
    <link rel="stylesheet" href="assets/styles/styles.css"> <!-- Path updated to new assets directory -->
</head>
<body>
    <header>
        <h1>EVE Online Capital Ship Production</h1>
    </header>

    <main>
        <div class="center-content">
            <h2>Corporation Details</h2>
            <?php if ($corpData): ?>
                <div class="corp-details">
                    <!-- Check if corporation_id exists before trying to use it -->
                    <img src="https://image.eveonline.com/Corporation/<?php echo htmlspecialchars($corpData['corporation_id'] ?? ''); ?>_128.png" alt="Corp Logo" class="corp-logo">
                    <p><strong>Corporation Name:</strong> <?php echo htmlspecialchars($corpData['name'] ?? 'Unknown'); ?></p>
                    <p><strong>CEO:</strong> <?php echo htmlspecialchars($corpData['ceo_name'] ?? 'Unknown'); ?></p>
                    <p><strong>Founded:</strong> <?php echo isset($corpData['date_founded']) ? date('F j, Y', strtotime($corpData['date_founded'])) : 'Unknown'; ?></p>
                    <p><strong>Member Count:</strong> <?php echo htmlspecialchars($corpData['member_count'] ?? 'Unknown'); ?></p>
                </div>
            <?php else: ?>
                <p>Corporation data is unavailable at the moment. Please check back later.</p>
            <?php endif; ?>

            <a href="includes/oauth.php" class="btn">Sign in with EVE Online</a> <!-- Path updated to includes directory -->
        </div>
    </main>

    <footer>
        <p>&copy; 2024 EVE Online Capital Ship Production</p>
    </footer>

</body>
</html>
