<?php
include("../db_connection.php");


// Fetch data from the database
if (isset($_GET['uc_no'])) {
    $uc_no = $_GET['uc_no'];
} else {
    die("Invalid Input value to generate calendar");
}

$sql = "SELECT uc_start_date, uc_end_date, uc_msg, uc_date_event_csv, uc_img_csv, uc_event_details_csv , uc_page_header , uc_page_footer 
        FROM user_calendar 
        WHERE uc_no = ? 
        LIMIT 1";

// Prepare the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uc_no);

// Execute the query
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
    <title>12 Page Calendar</title>
    <link rel="icon" type="image/png" href="../img/favicon.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/one_month_cal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Platypi&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jaro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Moul&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Miltonian+Tattoo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background: #f0f0f0;
            align-items: center;
        }

        .month {
            width: 100%;
            border: 1px solid black;
            border-radius: 10px;
            background: white;
            margin-bottom: 3px;
            background-image: url(https://img.freepik.com/premium-photo/white-wall-with-feathers-it-white-background_1290686-24678.jpg?w=826);

        }

        .month-image {
            text-align: center;


        }

        .month-image img {
            height: 8in;
            object-fit: cover;
            -webkit-user-drag: none;



        }

        #calendar {
            width: 100%;
            font-weight: bold;
            justify-content: center;
        }

        td {
            font-size: 43px;
            font-family: "Jaro", sans-serif;
            font-weight: 400;
        }

        th {

            font-size: 43px;
            background-color: cadetblue;
            font-family: "Racing Sans One", sans-serif;
            font-weight: 400;

        }

        td.sunday {
            color: red;
        }

        td.saturday {
            color: #56afdb;
        }

        .month-name {
            font-size: 45px;
            font-weight: bold;
            text-align: center;
            font-family: "Platypi", serif;
            background-color: antiquewhite;
        }


        .footer {
            font-size: 22px;
            text-align: center;
            background-color: lightgrey;
            border-radius: 5px;
            font-family: "Miltonian Tattoo", serif;
            font-weight: 400;
        }

        .highlight {
            background-color: grey;
            color: black;
            height: 10px;
        }

        .fa-birthday-cake {
            font-size: 30px;
        }



        .year-header {
            height: 60px;
            font-size: 30px;
            padding-left: 10px;
            display: flex;
            background-color: darkgray;
            font-family: "Platypi", serif;
            padding-left: 20px;


        }

        .year-header h3 {
            margin-left: 80px;
            padding-left: 470px;
            font-weight: bold;



        }

        .year-header span {
            margin-left: 65%;
        }

        .uc_msg {
            font-size: 25px;
            text-align: center;
            background-color: lightgrey;
            font-family: "Moul", serif;
            font-weight: 400;
            text-shadow: 2px 2px 5px skyblue;
        }

        @media print {

            .hide-on-print,
            .hide-on-print * {
                display: none !important;
            }

            .page-break {
                display: block;
                page-break-after: always;
            }
        }

        .btn-top {
            display: none;
            cursor: pointer;
            position: fixed;
            bottom: 20px;
            right: 30px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgb(12, 12, 12);
            color: white;
            border: none;
        }

        small {
            font-size: 20px;
            color: green;
        }

        .page-header {
            padding-bottom: 30px;

        }

        .zoom-container {
            position: relative;
            overflow: hidden;
            height: 8in;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .zoom-container img {
            position: absolute;
            cursor: grab;
            transition: transform 0.2s;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) scale(1);
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

        @media only screen and (max-width: 600px) {
            .reservation-box {
                display: none;
            }
        }
    </style>

</head>

<body onload="set_cal_months()">
    <div class="hide-on-print">
        <?php
        //  include "../nav/sidebar.php";
        ?>
    </div>
    <div class="reservation-box hide-on-print">
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
                    <button type="button" class="btn button ok" id="btnID" onclick="generateCalendar()" disabled><strong>Generate Calendar</strong></button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div id="p1">

            <div id="image" class="month-image"></div>
            <br>
            <div id="calendar"></div>
            <div class="footer">
                <div id="uc_event_dates" style="font-size: 16px; color: black;"></div>
                <div id="page-footer"></div>

            </div>
            <button id="button-dis" class="hide-on-print" onclick="printCalendar()" style="margin-left:50%;">Print Calendar</button>
        </div>
    </div>
    <button class="btn-top hide-on-print"><i class="bi bi-chevron-up"></i></button>
    <script>
        function set_cal_months() {
            var startDate = "<?php echo $startDate; ?>";
            var endDate = "<?php echo $endDate; ?>";
            var uc_msg = "<?php echo addslashes($uc_msg); ?>";
            var uc_date_event_csv = "<?php echo $uc_date_event_csv; ?>";
            var uc_img_csv = "<?php echo $uc_img_csv; ?>";
            var uc_event_details_csv = "<?php echo $uc_event_details_csv; ?>";
            var uc_page_header = "<?php echo addslashes($uc_page_header); ?>";
            var uc_page_footer = "<?php echo addslashes($uc_page_footer); ?>";


            var eventDates = uc_date_event_csv.split(',');
            var imagePaths = uc_img_csv.split(',').slice(0, 12);
            var eventDetails = uc_event_details_csv.split(',');

            console.log("Page Header: ", uc_page_header);
            console.log("Page Footer: ", uc_page_footer);
            console.log("Start Date: ", startDate);
            console.log("End Date: ", endDate);
            console.log("Message: ", uc_msg);
            console.log("Event Dates CSV: ", uc_date_event_csv);
            console.log("Event Details CSV: ", uc_event_details_csv);

            document.getElementById('uc_start_date').value = startDate;
            document.getElementById('uc_end_date').value = endDate;

            if (uc_msg) {
                var msgContainer = document.getElementById('uc_message');
                if (msgContainer) {
                    msgContainer.innerHTML = uc_msg;
                } else {
                    console.error('Message container element not found');
                }
            }

            if (typeof generateCalendar === "function") {
                generateCalendar(eventDates, imagePaths, uc_msg, eventDetails, uc_page_header);
            }

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
        }

        const months = [
            "January", "February", "March", "April",
            "May", "June", "July", "August",
            "September", "October", "November", "December"
        ];

        const calendar = document.getElementById('calendar');
        const startDateInput = document.getElementById('uc_start_date');
        const endDateInput = document.getElementById('uc_end_date');

        function generateCalendar(eventDates = [], imagePaths = [], uc_msg = "", eventDetails = [], uc_page_header = "") {
    var secondButton = document.getElementById("button-dis");
    secondButton.style.display = "block";

    calendar.innerHTML = '';

    const startDate = new Date(startDateInput.value);
    const endDate = new Date(endDateInput.value);
    let currentYear = startDate.getFullYear();

    let month = startDate.getMonth();

    while (month < 12) {
        const year = startDate.getFullYear();

        const monthDiv = document.createElement('div');
        monthDiv.classList.add('month');

        const currentImage = imagePaths[month] ? '../uploads/' + imagePaths[month].trim() : '';

        monthDiv.innerHTML = `
            <div class="year-header">${year} <span class="page-header">${uc_page_header}</span></div>
            <div class="month-image zoom-container">
                <img src="${currentImage}" alt="${months[month]} Image">
                <div class="zoom-buttons hide-on-print">
                    <button class="zoom-in"><i class="bi bi-zoom-in"></i></button>
                    <button class="zoom-out"><i class="bi bi-zoom-out"></i></button>
                    <button id="top-left"><i class="bi bi-arrow-left"></i></button>
                    <button id="top-center"><i class="bi bi-arrows"></i></button>
                    <button id="top-right"><i class="bi bi-arrow-right"></i></button>
                    <button id="bottom-left"><i class="bi bi-arrow-up"></i></button>
                    <button id="bottom-center"><i class="bi bi-arrows-vertical"></i></button>
                    <button id="bottom-right"><i class="bi bi-arrow-down"></i></button>
                </div>
            </div>
            <div class="uc_msg">${uc_msg}</div>
            <h4 class="month-name">${months[month]} ${year}</h4>
            <table style="height:500px;">
                <thead>
                    <tr style="text-align: center;">
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th style="color: blue;">Sat</th>
                        <th style="color: red;">Sun</th>
                    </tr>
                </thead>
                <tbody id="month${month + 1}_${year}"></tbody>
            </table>
        `;
        calendar.appendChild(monthDiv);

        const pageBreakDiv = document.createElement('div');
        pageBreakDiv.classList.add('page-break');
        calendar.appendChild(pageBreakDiv);

        populateDays(month + 1, year, eventDates, eventDetails, monthDiv);

        month++;
    }

    // Initialize zoom and drag functionality
    document.querySelectorAll('.zoom-container').forEach(container => {
        const img = container.querySelector('img');
        const zoomInBtn = container.querySelector('.zoom-in');
        const zoomOutBtn = container.querySelector('.zoom-out');

        let scale = 1;
        let originX = 0;
        let originY = 0;

        zoomInBtn.addEventListener('click', () => {
            scale += 0.1;
            img.style.transform = `scale(${scale})`;
        });

        zoomOutBtn.addEventListener('click', () => {
            if (scale > 0.1) {
                scale -= 0.1;
                img.style.transform = `scale(${scale})`;
            }
        });

        // Dragging functionality
        let isDragging = false;
        let startX, startY;

        img.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.clientX - img.offsetLeft;
            startY = e.clientY - img.offsetTop;
            img.style.cursor = 'grabbing';
        });

        img.addEventListener('mouseup', () => {
            isDragging = false;
            img.style.cursor = 'grab';
        });

        img.addEventListener('mouseleave', () => {
            isDragging = false;
            img.style.cursor = 'grab';
        });

        img.addEventListener('mousemove', (e) => {
            if (isDragging) {
                e.preventDefault();
                const x = e.clientX - startX;
                const y = e.clientY - startY;
                img.style.left = `${x}px`;
                img.style.top = `${y}px`;
            }
        });

        // Positioning functionality
        container.querySelector('#top-left').addEventListener('click', () => {
            img.style.left = '0';
            img.style.top = '0';
            img.style.transform = `translate(0, 0) scale(${scale})`;
        });

        container.querySelector('#top-center').addEventListener('click', () => {
            img.style.left = '50%';
            img.style.top = '0';
            img.style.transform = `translate(-50%, 0) scale(${scale})`;
        });

        container.querySelector('#top-right').addEventListener('click', () => {
            img.style.left = '100%';
            img.style.top = '0';
            img.style.transform = `translate(-100%, 0) scale(${scale})`;
        });

        container.querySelector('#bottom-left').addEventListener('click', () => {
            img.style.left = '0';
            img.style.top = '100%';
            img.style.transform = `translate(0, -100%) scale(${scale})`;
        });

        container.querySelector('#bottom-center').addEventListener('click', () => {
            img.style.left = '50%';
            img.style.top = '100%';
            img.style.transform = `translate(-50%, -100%) scale(${scale})`;
        });

        container.querySelector('#bottom-right').addEventListener('click', () => {
            img.style.left = '100%';
            img.style.top = '100%';
            img.style.transform = `translate(-100%, -100%) scale(${scale})`;
        });
    });
}

        function addYearHeader(year) {
            const yearHeader = document.createElement('div');
            yearHeader.classList.add('year-header');
            yearHeader.textContent = year;
            calendar.appendChild(yearHeader);
        }

        function populateDays(month, year, eventDates, eventDetails, monthDiv) {
            const monthBody = monthDiv.querySelector(`#month${month}_${year}`);
            const daysInMonth = new Date(year, month, 0).getDate();
            let dayCount = 1;
            const firstDay = new Date(year, month - 1, 1).getDay(); // First day of the month

            // Adjust first day (Monday = 0, Sunday = 6)
            const adjustedFirstDay = (firstDay === 0) ? 6 : firstDay - 1;

            // Helper function to convert date format from 'YYYY/MM/DD' to 'YYYY-MM-DD'
            function convertDateFormat(dateStr) {
                return dateStr.replace(/\//g, '-');
            }

            // Convert all dates in the array
            const formattedEventDates = eventDates.map(convertDateFormat);

            // Loop through the weeks (rows)
            for (let i = 0; i < 6; i++) {
                const row = document.createElement('tr');

                // Loop through the days of the week (cells)
                for (let j = 0; j < 7; j++) {
                    const cell = document.createElement('td');

                    // Add empty cells for the days before the start of the month
                    if (i === 0 && j < adjustedFirstDay) {
                        cell.textContent = '';
                    } else {
                        // Check if the current day is within the month
                        if (dayCount <= daysInMonth) {
                            // Format the current date as YYYY-MM-DD
                            const currentDate = `${year}-${String(month).padStart(2, '0')}-${String(dayCount).padStart(2, '0')}`;

                            // Check if the current date is in the event dates array
                            if (formattedEventDates.includes(currentDate)) {
                                cell.innerHTML = `${dayCount} <i class="fa fa-birthday-cake" style="color: red;"></i>`; // Add birthday icon
                                cell.classList.add('highlight');

                                // Add event details within the cell for the respective date
                                const eventIndex = formattedEventDates.indexOf(currentDate);
                                const eventDetail = eventDetails[eventIndex];
                                cell.innerHTML += `<br><small>${eventDetail}</small>`;
                            } else {
                                cell.textContent = dayCount;
                            }

                            // Highlight Saturday and Sunday
                            if (j === 5) {
                                cell.style.color = 'blue'; // Saturday
                            } else if (j === 6) {
                                cell.style.color = 'red'; // Sunday
                            }

                            dayCount++;
                        } else {
                            cell.textContent = ''; // Empty cells after the end of the month
                        }
                    }
                    row.appendChild(cell);
                }
                monthBody.appendChild(row);
            }
        }


        function printCalendar() {
            window.print();
        }

        const button = document.querySelector('.btn-top');

        const displayButton = () => {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 100) {
                    button.style.display = "block";
                } else {
                    button.style.display = "none";
                }
            });
        };

        const scrollToTop = () => {
            button.addEventListener("click", () => {
                window.scroll({
                    top: 0,
                    left: 0,
                    behavior: 'smooth'
                });
            });
        };

        displayButton();
        scrollToTop();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>