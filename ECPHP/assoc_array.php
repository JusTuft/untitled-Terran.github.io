<!DOCTYPE html>
<html>
<head>
    <title>Office Hours</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 50px;
            background-color: #f4f4f4;
        }
        .hours-container {
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .hours-container h2 {
            text-align: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin: 20px 20px 10px 20px;
        }
        .hours-list {
            list-style: none;
            padding: 0 20px 20px 20px;
            margin: 0;
        }
        .hours-list li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .hours-list li:last-child {
            border-bottom: none;
        }
        .day {
            font-weight: bold;
        }
        .time {
            color: #555;
        }
    </style>
</head>
<body>

    <div class="hours-container">
        <h2>Office Hours</h2>
        <ul class="hours-list">
            <?php
            $office_hours = array(
                "Monday" => "9am - 4pm",
                "Tuesday" => "9am - 4pm",
                "Wednesday" => "9am - 1pm",
                "Thursday" => "9am - 4pm",
                "Friday" => "9am - 12pm",
                "Saturday" => "Closed",
                "Sunday" => "Closed"
            );

            foreach ($office_hours as $day => $hours) {
                echo "<li><span class='day'>$day</span> <span class='time'>$hours</span></li>";
            }
            ?>
        </ul>
    </div>

</body>
</html>