<?php
session_start();
require __DIR__ . '/../config.php'; 


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$filter_status = isset($_GET['status']) ? $_GET['status'] : 'all';
$search_keyword = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

$query = 'SELECT * FROM todolists WHERE user_id = ? AND title LIKE ?';

if ($filter_status == 'complete') {
    $query .= ' AND completion_status = "complete"';
} elseif ($filter_status == 'incomplete') {
    $query .= ' AND completion_status = "incomplete"';
}

$stmt = $pdo->prepare($query);
$stmt->execute([$user_id, $search_keyword]);
$lists = $stmt->fetchAll();

function get_completion_percentage($pdo, $list_id) {
    $total_details_stmt = $pdo->prepare('SELECT COUNT(*) FROM detaillists WHERE todolist_id = ?');
    $total_details_stmt->execute([$list_id]);
    $total_details = $total_details_stmt->fetchColumn();

    if ($total_details == 0) {
        return 0; 
    }

    $completed_details_stmt = $pdo->prepare('SELECT COUNT(*) FROM detaillists WHERE todolist_id = ? AND is_complete = 1');
    $completed_details_stmt->execute([$list_id]);
    $completed_details = $completed_details_stmt->fetchColumn();

    $percentage = round(($completed_details / $total_details) * 100, 2);

    if ($percentage == 100) {
        $pdo->prepare('UPDATE todolists SET completion_status = "complete" WHERE id = ?')->execute([$list_id]);
    }

    return $percentage;
}

$calendar_stmt = $pdo->prepare('SELECT d.title, d.due_date, d.is_complete, d.label_color FROM detaillists d JOIN todolists t ON d.todolist_id = t.id WHERE t.user_id = ?');
$calendar_stmt->execute([$user_id]);
$calendar_details = $calendar_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #b2f7b6, #ffffff);
            color: #000000;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .boux {
            background-color: rgba(255, 255, 255, 0.3);
            padding: 20px;
            width: 80%;
            max-width: 600px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 1);
            margin: 20px auto;
            border: 2px solid #8B4513;
        }

        h2 {
            color: #ffffff;
            margin-bottom: 20px;
        }

        h3 {
            color: #ffffff;
            margin-bottom: 10px;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            margin-right: 10px;
            border: none;
            outline: none;
            background-color: #f0f0f0;
            color: #000000;
            border-bottom: 1px solid #ffffff;
        }

        button {
            padding: 10px;
            background-color: transparent;
            color: #ffffff;
            border: 2px solid #8B4513;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #8B4513;
            color: #ffffff;
        }

        select {
            padding: 10px;
            border: none;
            outline: none;
            background-color: #f0f0f0;
            color: #000000;
            border-bottom: 1px solid #8B4513;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        li {
            margin-bottom: 15px;
        }

        a {
            color: #ffffff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .delete {
            color: red;
        }

        .progress-bar {
            width: 100%;
            background-color: #f0f0f0;
            border: 1px solid #8B4513;
            border-radius: 6px;
            height: 20px;
            margin-top: 10px;
        }

        .progress {
            background-color: #8B4513;
            height: 100%;
            width: 0;
            border-radius: 5px;
            text-align: center;
            color: #fff;
            line-height: 20px;
        }

        #calendar {
            margin-top: 30px;
            margin-bottom: 20px;
        }

        #calendar table {
            width: 100%;
            border-collapse: collapse;
        }

        #calendar th, #calendar td {
            padding: 10px;
            border: 1px solid #8B4513;
            text-align: center;
        }

        #calendar td {
            position: relative;
        }

        #calendar td div {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            position: absolute;
            bottom: 5px;
            right: 5px;
        }

        .calendar-navigation {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            align-items: center;
        }

        .month-year-display {
            padding: 10px;
            background-color: transparent;
            color: #ffffff;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        @media (max-width: 600px) {
            #calendar table {
                width: 100%;
                font-size: 12px; 
            }

            #calendar th, #calendar td {
                padding: 5px;
            }

            .calendar-navigation {
                flex-direction: column; 
                gap: 10px;
            }

            .month-year-display {
                font-size: 14px; 
            }

            button {
                padding: 5px; 
            }
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .video-background video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="video-background">
        <video autoplay loop muted>
            <source src="../assets/videos/Starry Night Time-Lapse 4K UHD | Free Stock Video - BULLAKI (1080p, h264, youtube).mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <div class="boux">
        <h2>YOUR TO-DO LIST</h2>

        <form method="GET" action="dashboard.php">
            <input type="text" name="search" placeholder="Search tasks" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit">Search</button>
        </form>

        <form method="GET" action="dashboard.php">
            <label for="status">Filter by Status:</label>
            <select name="status" id="status">
                <option value="all" <?= $filter_status == 'all' ? 'selected' : '' ?>>All</option>
                <option value="complete" <?= $filter_status == 'complete' ? 'selected' : '' ?>>Completed</option>
                <option value="incomplete" <?= $filter_status == 'incomplete' ? 'selected' : '' ?>>Incomplete</option>
            </select>
            <button type="submit">Apply Filter</button>
        </form>

        <ul>
            <?php foreach ($lists as $list): ?>
                <li>
                    <a href="view_list.php?id=<?= $list['id'] ?>"><?= htmlspecialchars($list['title']) ?></a> - 
                    Status: <?= htmlspecialchars($list['completion_status']) ?>

                    <?php if ($list['completion_status'] == 'incomplete'): ?>
                        <a href="mark_complete.php?id=<?= $list['id'] ?>">Mark as Completed</a>
                    <?php else: ?>
                        <a href="mark_incomplete.php?id=<?= $list['id'] ?>">Mark as Incomplete</a>
                    <?php endif; ?>
                    
                    <a class="delete" href="delete_list.php?id=<?= $list['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>

                    <div class="progress-bar">
                        <div class="progress" style="width: <?= get_completion_percentage($pdo, $list['id']) ?>%;">
                            <?= get_completion_percentage($pdo, $list['id']) ?>%
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <h3>Your Calendar</h3>
        <div class="calendar-navigation">
            <button onclick="navigateCalendar(-1)">Previous Month</button>
            <span class="month-year-display" id="month-year"></span>
            <button onclick="navigateCalendar(1)">Next Month</button>
        </div>
        <div id="calendar"></div>

        <a href="create_list.php">Create New To-Do List</a>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script>
        const calendarData = <?= json_encode($calendar_details); ?>;
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        function generateCalendar(month, year) {
            const firstDay = new Date(year, month).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            let calendarHtml = '<table><tr>';
            const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

            daysOfWeek.forEach(day => calendarHtml += `<th>${day}</th>`);
            calendarHtml += '</tr><tr>';

            for (let i = 0; i < firstDay; i++) {
                calendarHtml += '<td></td>';
            }

            for (let date = 1; date <= daysInMonth; date++) {
                const fullDate = `${year}-${(month + 1).toString().padStart(2, '0')}-${date.toString().padStart(2, '0')}`;
                let backgroundColor = '';
                let labelColor = '';

                calendarData.forEach(item => {
                    if (item.due_date === fullDate) {
                        backgroundColor = item.is_complete ? 'green' : 'red';
                        labelColor = item.label_color;
                    }
                });

                calendarHtml += `<td style="background-color: ${backgroundColor}; position: relative;">${date}`;
                if (labelColor) {
                    calendarHtml += `<div style="position: absolute; bottom: 5px; right: 5px; width: 10px; height: 10px; background-color: ${labelColor}; border-radius: 50%;"></div>`;
                }
                calendarHtml += `</td>`;

                if ((date + firstDay) % 7 === 0) {
                    calendarHtml += '</tr><tr>';
                }
            }
            calendarHtml += '</tr></table>';
            document.getElementById('calendar').innerHTML = calendarHtml;
            document.getElementById('month-year').innerText = `${monthNames[month]} ${year}`;
        }

        function navigateCalendar(direction) {
            currentMonth += direction;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear -= 1;
            } else if (currentMonth > 11) {
                currentMonth = 0;
                currentYear += 1;
            }
            generateCalendar(currentMonth, currentYear);
        }

        document.addEventListener("DOMContentLoaded", function() {
            generateCalendar(currentMonth, currentYear);
        });
    </script>
</body>
</html>
