<?php
    
    require_once('./ical/ical.php');

    // Get all future events from ics file
    $calendar = new iCal("https://calendar.google.com/calendar/ical/de.german%23holiday%40group.v.calendar.google.com/public/basic.ics");
    $icsEvents = $calendar->getEventsAfterDate(date('Y-m-d'));

?>

<!DOCTYPE html>
<html lang="de">
<head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>PHP ical parser</title>
    
</head>
<body>

<section class="container" id="main">
    <h1>Events from ics file</h1>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>&nbsp;</th>
                    <th>Start</th>
                    <th>End</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($icsEvents as $event): ?>
                    <tr>
                        <td><strong><?= $event->title ?></strong></td>
                        <td><?= $event->description ?></td>
                        <td><?= $event->startDateTime ?></td>
                        <td><?= $event->endDateTime ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<section class="footer container">
    <p class="text-center">© 2020 – <?= date('Y') ?> maxdecor - Design Solutions</a></p>
</section>

</body>
</html>