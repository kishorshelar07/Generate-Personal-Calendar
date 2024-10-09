<?php
include("../db_connection.php");

// Get user value in user_calendar table
if (isset($_GET['uc_no'])) {
    $uc_no = $_GET['uc_no'];
} else {
    die("Invalid Input value to generate calendar");
}

// Fetch uc_start_date, uc_end_date, uc_msg, uc_date_event_csv, uc_img_csv, and uc_event_details_csv from the database
$sql = "SELECT uc_start_date, uc_end_date, uc_msg, uc_date_event_csv, CONCAT('../uploads/', uc_img_csv) as uc_img_csv, uc_event_details_csv ,uc_page_header, uc_page_footer FROM user_calendar WHERE uc_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uc_no);
$stmt->execute();
$result = $stmt->get_result();

$startDate = "";
$endDate = "";
$uc_msg = "";
$uc_date_event_csv = "";
$uc_img_csv = "";
$uc_event_details_csv = "";
$uc_page_header = "";
$uc_page_footer = "";

if ($result->num_rows > 0) {
    // Fetch the first row of data
    $row = $result->fetch_assoc();
    $startDate = $row['uc_start_date'];
    $endDate = $row['uc_end_date'];
    $uc_msg = $row['uc_msg'];
    $uc_date_event_csv = $row['uc_date_event_csv'];
    $uc_img_csv = $row['uc_img_csv'];
    $uc_event_details_csv = $row['uc_event_details_csv'];
    $uc_page_header = $row['uc_page_header'];
    $uc_page_footer = $row['uc_page_footer'];
}

// Close connection
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3 Page Calendar</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/one_month_cal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="icon" type="image/png" href="../img/favicon.png">

    <style>
        .page {
            height: 15in;
            width: 100%;
            page-break-after: always;
            padding: 10px;
            border: 5px solid #008080;
            border-radius: 10px;
            background: white;
            margin-bottom: 10px;
            background-image: url(https://img.freepik.com/premium-vector/abstract-template-with-plants-flowers-bauhaus-floral-background-with-geometric-shapes_868719-660.jpg?w=740);
        }

        .page:last-child {
            page-break-after: auto;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: auto auto;
            gap: 20px;
            padding-left: 10px;

        }

        .month {
            width: 100%;
            padding: 5px;
            background: white;
            background-image: url(https://img.freepik.com/premium-photo/full-frame-shot-white-background_1048944-10425956.jpg?size=626&ext=jpg&ga=GA1.1.1193779748.1721371541&semt=ais_user);

        }

        .month-image {
            display: flex;
            justify-content: center;
            align-items: center;


        }

        .month-image img {
            height: 550px;
            border-radius: 10px;

        }

        th {
            background-color: paleturquoise;
        }

        #calendar {
            width: 100%;
            font-weight: bold;
            justify-content: center;

        }

        td,
        th {
            font-size: 20px;
            height: 40px;
        }

        td.sunday {
            color: red;
        }

        .month-year {
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            background-color: mediumaquamarine;


        }

        .footer {
            font-size: 16px;
            text-align: center;
            background-color: lightgrey;
            border-radius: 5px;
            padding: 5px;
        }

        .highlight {
            background-color: grey;
            color: black;
        }

        .fa-birthday-cake {
            font-size: 10px;
        }

        .year-header {
            height: 40px;
            font-size: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: darkgray;
            margin-bottom: 5px;
            border-radius: 5px;
            padding: 10px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            margin-left: 20px;
            margin-right: 20px;
        }

        .page-header h2 {
            font-size: 30px;
            font-weight: bold;
        }

        p {
            font-size: 10px;
        }

        @media print {

            .hide-on-print,
            .hide-on-print * {
                display: none !important;
            }
        }


        .zoom-container {
            position: relative;
            overflow: hidden;
            height: 5.5in;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .zoom-container img {
            position: absolute;
            cursor: move;
            transition: transform 0.2s;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) scale(1);
            -webkit-user-drag: none;
        }

        .zoom-buttons {
            position: absolute;
            bottom: 10px;
            left: 10px;
            display: flex;
            gap: 10px;

        }

        .zoom-buttons button {
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            background-color: lightgray;
        }

        .page-footer {
            margin-bottom: 20px;
        }


        @media only screen and (max-width: 600px) {
            .reservation-box {
                display: none;
            }
        }
    </style>
    <script>
        function set_cal_months() {
            // Use PHP to set JavaScript variables
            var startDate = "<?php echo $startDate; ?>";
            var endDate = "<?php echo $endDate; ?>";
            var uc_msg = "<?php echo addslashes($uc_msg); ?>"; // Add slashes to escape quotes
            var uc_date_event_csv = "<?php echo $uc_date_event_csv; ?>"; // Event dates as CSV
            var uc_img_csv = "<?php echo $uc_img_csv; ?>"; // Image paths as CSV
            var uc_event_details_csv = "<?php echo $uc_event_details_csv; ?>"; // Event details as CSV
            var uc_page_header = "<?php echo addslashes($uc_page_header); ?>";
            var uc_page_footer = "<?php echo addslashes($uc_page_footer); ?>";

            // Debugging log to check variables
            console.log("startDate:", startDate);
            console.log("endDate:", endDate);
            console.log("uc_msg:", uc_msg);
            console.log("uc_date_event_csv:", uc_date_event_csv);
            console.log("uc_img_csv:", uc_img_csv);
            console.log("uc_event_details_csv:", uc_event_details_csv);

            // Parse CSV strings into arrays
            var eventDates = uc_date_event_csv.split(',');
            var imagePaths = uc_img_csv.split(',').map(path => '../uploads/' + path.trim());
            var eventDetails = uc_event_details_csv.split(',');

            // Debugging log to check arrays
            console.log("eventDates:", eventDates);
            console.log("imagePaths:", imagePaths);
            console.log("eventDetails:", eventDetails);

            // // Check if image paths are correct
            // imagePaths.forEach((path, index) => {
            //     const img = new Image();
            //     img.onload = function() {
            //         console.log("Image loaded successfully: " + path);
            //     };
            //     img.onerror = function() {
            //         console.error("Image not found: " + path);
            //     };
            //     img.src = path;
            // });

            // Set the values in the input fields
            document.getElementById('uc_start_date').value = startDate;
            document.getElementById('uc_end_date').value = endDate;


            // Set the page header and footer
            var headerDiv = document.getElementById('page-header');
            if (headerDiv) {
                headerDiv.innerHTML = uc_page_header;
            } else {
                console.error('Header container element not found');
            }

            var footerDiv = document.getElementById('page-footer');
            if (footerDiv) {
                footerDiv.innerHTML = uc_page_footer;
            } else {
                console.error('Footer container element not found');
            }


            // Display the message on the calendar
            if (uc_msg) {
                var msgContainer = document.getElementById('uc_message');
                if (msgContainer) {
                    msgContainer.innerHTML = uc_msg;
                } else {
                    console.error('Message container element not found');
                }
            }

            // Display the event dates in the footer
            var eventDatesContainer = document.getElementById('uc_event_dates');
            if (eventDatesContainer) {
                eventDatesContainer.textContent = 'Event Dates: ' + uc_date_event_csv;
                eventDatesContainer.style.display = 'block'; // Ensure the container is visible
            } else {
                console.error('Event dates container element not found');
            }

            // Call the generateCalendar function and pass the event dates and image paths
            if (typeof generateCalendar === "function") {
                generateCalendar(eventDates, imagePaths, uc_msg, eventDetails);
            }
        }
    </script>


</head>

<body onload="set_cal_months()">
    <div class="hide-on-print">
        <?php include "../nav/sidebar.php";
        ?>
    </div>
    <div class="reservation-box hide-on-print" action="add_action.php" method="POST">
        <div class="top">
            <h1 class="hide-on-print">Calendar Generator</h1><br>
            <div class="static col-md-4">
                <div class="input-container">
                    <label for="startDate">Start Date:</label>
                    <input type="date" id="uc_start_date" name="uc_start_date" disabled>
                </div>
            </div>
            <div class="flex col-md-4">
                <div class="input-container" id="date-picker-container">
                    <label for="endDate">End Date:</label>
                    <input type="date" id="uc_end_date" name="uc_end_date" disabled>
                </div>
                <div class="button-container col-md-4">
                    <button type="button" class="btn button ok " id="btnID" onclick="generateCalendar()" disabled><strong>Generate Calendar</strong></button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div id="calendar"></div>
        <div class="footer">
            <div id="uc_event_dates" style="display: none;"></div>
            <div id="page-footer"></div>
        </div>

        <button id="button-dis" class="hide-on-print" onclick="printCalendar()" style="margin-left:50%;">Print Calendar</button>
    </div>

    <script>
        const months = [
            "January", "February", "March", "April",
            "May", "June", "July", "August",
            "September", "October", "November", "December"
        ];

        const calendar = document.getElementById('calendar');
        const startDateInput = document.getElementById('uc_start_date');
        const endDateInput = document.getElementById('uc_end_date');

        function generateCalendar(eventDates = [], imagePaths = [], uc_msg = "", eventDetails = []) {
            // Show print button
            var secondButton = document.getElementById("button-dis");
            secondButton.style.display = "block";

            // Clear previous calendar
            calendar.innerHTML = '';

            // Get start and end dates
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            let currentYear = startDate.getFullYear();
            let monthCount = 0;
            let pageCount = 1;

            // Create a new page container
            let pageContainer = createPageContainer(pageCount, imagePaths[pageCount - 1], currentYear);

            // Generate calendar for each month within the date range
            while (startDate <= endDate && monthCount < 12) {
                if (monthCount % 4 === 0 && monthCount !== 0) {
                    // Create a new page container after every 4 months
                    pageCount++;
                    pageContainer = createPageContainer(pageCount, imagePaths[pageCount - 1], currentYear);
                }

                const month = startDate.getMonth();
                const year = startDate.getFullYear();

                // Add new year header if the year changes
                if (year !== currentYear) {
                    currentYear = year;
                    pageContainer = createPageContainer(pageCount, imagePaths[pageCount - 1], currentYear);
                }

                const monthDiv = document.createElement('div');
                monthDiv.classList.add('month');

                monthDiv.innerHTML = `
            <h4 class="month-year">${months[month]} ${year}</h4>
            <table style="height:250px;">
                <thead>
                    <tr style="text-align:center;" >
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th style="color:blue ;">Sat</th>
                        <th style="color: red;">Sun</th>
                    </tr>
                </thead>
                <tbody id="month${month + 1}_${year}"></tbody>
            </table>
        `;
                pageContainer.querySelector('.calendar-grid').appendChild(monthDiv);

                populateDays(month + 1, year, eventDates, eventDetails);

                // Add the uc_msg to each page's footer
                const pageFooter = pageContainer.querySelector('.page-footer');
                if (pageFooter) {
                    const eventDetailsForMonth = getEventDetailsForMonth(eventDates, eventDetails, month + 1, year);
                    pageFooter.innerHTML = `
                <br><div style="font-size:22px;">${uc_msg}</div>
             
            `;
                }

                // Move to next month
                startDate.setMonth(startDate.getMonth() + 1);
                monthCount++;
            }
        }

        function createPageContainer(pageCount, imagePath, year) {
    const pageContainer = document.createElement('div');
    pageContainer.classList.add('page');
    pageContainer.id = `page${pageCount}`;
    pageContainer.innerHTML = `
        <div class="page-header">
            <h2>C-Infotech, Pune</h2>
            <h2>${year}</h2>
        </div>

        <div class="month-image zoom-container">
            <img src="${imagePath}" alt="Page ${pageCount} Image" class="zoomable-image" id="image1">
            <div class="zoom-buttons hide-on-print">
                <button class="zoom-in"><i class="bi bi-zoom-in"></i></button>
                <button class="zoom-out"><i class="bi bi-zoom-out"></i></button>
                <button id="top-left"><i class="bi bi-arrow-left"></i></button>
                <button id="top-center"><i class="bi bi-arrows"></i></button>
                <button id="top-right"><i class="bi bi-arrow-right"></i></button>
                <button id="bottom-left"><i class="bi bi-arrow-up"></i></button>
                <button id="bottom-center"><i class="bi bi-arrows-vertical"></i></button>
                <button id="bottom-right"><i class="bi bi-arrow-down"></i></i></button>
            </div>
        </div>
        <div class="page-footer text-center"></div>
        <div class="calendar-grid col-12 col-sm-12 col-md-12 col-lg-12"></div>
    `;
    calendar.appendChild(pageContainer);

    // Initialize zoom level and position
    let scale = 1;
    let xPos = 0;
    let yPos = 0;
    let isDragging = false;
    let startX, startY;

    const img = pageContainer.querySelector('.zoomable-image');

    // Zoom in
    pageContainer.querySelector('.zoom-in').addEventListener('click', () => {
        scale += 0.1;
        updateTransform();
    });

    // Zoom out
    pageContainer.querySelector('.zoom-out').addEventListener('click', () => {
        scale = Math.max(1, scale - 0.1);
        updateTransform();
    });

    // Add event listeners for positioning buttons
    pageContainer.querySelector('#top-left').addEventListener('click', () => {
        xPos = -img.clientWidth / 2;
        yPos = -img.clientHeight / 2;
        updateTransform();
    });

    pageContainer.querySelector('#top-center').addEventListener('click', () => {
        xPos = 0;
        yPos = -img.clientHeight / 2;
        updateTransform();
    });

    pageContainer.querySelector('#top-right').addEventListener('click', () => {
        xPos = img.clientWidth / 2;
        yPos = -img.clientHeight / 2;
        updateTransform();
    });

    pageContainer.querySelector('#bottom-left').addEventListener('click', () => {
        xPos = -img.clientWidth / 2;
        yPos = img.clientHeight / 2;
        updateTransform();
    });

    pageContainer.querySelector('#bottom-center').addEventListener('click', () => {
        xPos = 0;
        yPos = img.clientHeight / 2;
        updateTransform();
    });

    pageContainer.querySelector('#bottom-right').addEventListener('click', () => {
        xPos = img.clientWidth / 2;
        yPos = img.clientHeight / 2;
        updateTransform();
    });

    // Add mouse events for dragging the image
    img.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.clientX - xPos;
        startY = e.clientY - yPos;
    });

    window.addEventListener('mousemove', (e) => {
        if (isDragging) {
            xPos = e.clientX - startX;
            yPos = e.clientY - startY;
            updateTransform();
        }
    });

    window.addEventListener('mouseup', () => {
        isDragging = false;
    });

    // Update transform based on scale and position
    function updateTransform() {
        img.style.transform = `translate(${xPos}px, ${yPos}px) scale(${scale})`;
    }

    return pageContainer;
}


        function populateDays(month, year, eventDates, eventDetails) {
            const monthBody = document.getElementById(`month${month}_${year}`);
            const daysInMonth = new Date(year, month, 0).getDate();
            let dayCount = 1;

            for (let i = 0; i < 6; i++) {
                const row = document.createElement('tr');
                for (let j = 0; j < 7; j++) {
                    const cell = document.createElement('td');
                    if (i === 0 && j < (new Date(year, month - 1, 1).getDay() || 7) - 1) {
                        // Add empty cells for previous month
                        cell.textContent = '';
                    } else {
                        if (dayCount <= daysInMonth) {
                            // Check if the current date is in the event dates array
                            const currentDate = `${year}-${String(month).padStart(2, '0')}-${String(dayCount).padStart(2, '0')}`;
                            const eventIndex = eventDates.indexOf(currentDate);
                            if (eventIndex !== -1) {
                                const eventDetail = eventDetails[eventIndex];
                                cell.innerHTML = `${dayCount} <i class="fas fa-birthday-cake" style="color: red;"></i><br><p>${eventDetail}</p>`; // Add event detail
                                cell.classList.add('highlight');
                            } else {
                                cell.textContent = dayCount;
                            }

                            // Apply special styling for Sundays and Saturdays
                            if (j === 6) { // Sunday column
                                cell.classList.add('sunday');
                            } else if (j === 5) { // Saturday column
                                cell.style.color = 'blue';
                            }

                            dayCount++;
                        } else {
                            cell.textContent = '';
                        }
                    }
                    row.appendChild(cell);
                }
                monthBody.appendChild(row);
            }
        }

        function getEventDatesForMonth(eventDates, month, year) {
            const monthStr = String(month).padStart(2, '0');
            return eventDates.filter(date => date.startsWith(`${year}-${monthStr}`)).join(', ');
        }

        function getEventDetailsForMonth(eventDates, eventDetails, month, year) {
            const monthStr = String(month).padStart(2, '0');
            return eventDates
                .map((date, index) => date.startsWith(`${year}-${monthStr}`) ? eventDetails[index] : null)
                .filter(detail => detail !== null)
                .join(', ');
        }

        function printCalendar() {
            window.print();
        }
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>