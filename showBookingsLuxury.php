<?php

declare(strict_types=1);

// Function is called from index.php on page load.
// Shows bookings from database and calendar in browser.
function showBookingsLuxury()
{
    $database = new PDO("sqlite:bookings.db");

    $statement = $database->query('SELECT * FROM bookings WHERE room = "luxury"');

    // Fetches items from database query, gets item as associative array.
    $bookings = $statement->fetchAll(PDO::FETCH_ASSOC);

    $startDate = new DateTime("2023-01-01");
    $endDate = new DateTime("2023-02-01");
    $interval = DateInterval::createFromDateString('1 day');
    $january = new DatePeriod($startDate, $interval, $endDate);

    $dayCounter = 0;

    // Prints calendar
?>
    <div class="calendar-container">
        <?php foreach ($january as $day) :
            $day = $day->format("Y-m-d");
            $dayCounter++;
            $booked = "";

            foreach ($bookings as $booking) :
                if ($day >= $booking["arr_date"] && $day < $booking["dep_date"]) :
                    $booked = "booked";
                endif;
            endforeach; ?>

            <div class="<?= $booked; ?> calendar-item _<?= $dayCounter; ?>"><?= $dayCounter; ?></div>

        <?php endforeach; ?>
    </div>
<?php
}
