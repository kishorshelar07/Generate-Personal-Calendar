<?php
include("../db_connection.php");

// Get user value in user_calendar table
if (isset($_GET['uc_no'])) {
    $uc_no = $_GET['uc_no'];
} else {
    die("Invalid Input value to generate calendar");
}

// Fetch uc_start_date, uc_end_date, uc_msg, uc_date_event_csv, uc_img_csv, and uc_event_details_csv from the database
$sql = "SELECT uc_start_date, uc_end_date, uc_msg, uc_date_event_csv, uc_img_csv, uc_event_details_csv ,uc_page_header, uc_page_footer FROM user_calendar WHERE uc_no='$uc_no'";

$result = $conn->query($sql);

$startDate = "";
$endDate = "";
$uc_msg = "";
$uc_date_event_csv = [];
$uc_img_csv = [];
$uc_event_details_csv = [];
$uc_page_header = "";
$uc_page_footer = "";


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $startDate = $row['uc_start_date'];
        $endDate = $row['uc_end_date'];
        $uc_msg = $row['uc_msg'];
        $uc_date_event_csv[] = $row['uc_date_event_csv'];
        $uc_img_csv[] = $row['uc_img_csv'];
        $uc_event_details_csv[] = $row['uc_event_details_csv'];
        $uc_page_header = $row['uc_page_header'];
        $uc_page_footer = $row['uc_page_footer'];
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1 Page Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="icon" type="image/png" href="../img/favicon.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <style>
        .top {
            margin-left: 50px;
        }

        .highlight {
            background-color: grey;
            color: black;
        }

        .footer {
            margin-top: 8px;
            text-align: center;
            /* background-color: #f8f9fa; */
            border: 1px solid #e9ecef;
            background: transparent;


        }

        .footer p {
            font-size: 20px;
            font-weight: bold;

        }

        #p1 {
            border: solid 2px black;
            border-radius: 5px;
            height: 17in;
            width: 12in;
            margin: 10px auto;
        }

        .container-fluid {
            font-size: 12px;
        }

        #image {
            margin-left: 0px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        #image img {
            height: 500px;
            width: 385px;
        }

        #calendar {
            margin-left: 13px;


        }

        #calendar h4 {
            font-weight: bold;
            font-style: italic;
        }

        #uc_message {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            font-family: "Archivo Black", sans-serif;
            font-weight: 400;
            font-style: normal;
            text-shadow: 5px 2px 2px rgba(128, 117, 23, 1);

        }

        th,
        td {
            font-weight: bold;

        }

        h4 {
            background-color: mediumaquamarine;
        }

        .calendar-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            border: 2px solid gray;
        }

        .image-row {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        @media print {
            .hide-on-print {
                display: none;
            }
        }

        .bg-img {
            background-image: url(https://img.freepik.com/free-vector/green-leaf-shadow-frame-background_53876-116964.jpg?w=826&t=st=1721284789~exp=1721285389~hmac=1df51c5da0b180cf05e9b4b48bb4655c3be8e7e0b8a6ba2339cc322884f9b5aa);

        }

        .bg_img {
            height: 250px;
            background-image: url(https://img.freepik.com/free-vector/abstract-soft-colorful-watercolor-texture-background-design_1055-13464.jpg?size=626&ext=jpg&ga=GA1.1.1193779748.1721371541&semt=ais_user);

        }

        #page-header {
            padding-left: 60%;
            font-size: 30px;
            font-weight: bold;
            font-style: italic;


        }

        #year-header {
            margin-left: 15px;
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
            var uc_date_event_csv = <?php echo json_encode($uc_date_event_csv); ?>; // Event dates as array of CSVs
            var uc_img_csv = <?php echo json_encode($uc_img_csv); ?>; // Images as array of CSVs
            var uc_event_details_csv = <?php echo json_encode($uc_event_details_csv); ?>; // Event details as array of CSVs
            var uc_page_header = "<?php echo addslashes($uc_page_header); ?>";
            var uc_page_footer = "<?php echo addslashes($uc_page_footer); ?>";

            console.log("Page Header: ", uc_page_header);
            console.log("Page Footer: ", uc_page_footer);
            console.log("Start Date: ", startDate);
            console.log("End Date: ", endDate);
            console.log("Message: ", uc_msg);
            console.log("Event Dates CSV: ", uc_date_event_csv);
            console.log("Event Details CSV: ", uc_event_details_csv);



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

            // Parse and merge CSV strings into arrays
            var eventDates = [].concat(...uc_date_event_csv.map(csv => csv.split(',')));
            var images = [].concat(...uc_img_csv.map(csv => csv.split(',')));
            var eventDetails = [].concat(...uc_event_details_csv.map(csv => csv.split(',')));

            console.log(" Event Dates: ", eventDates);
            console.log(" Event Details: ", eventDetails);

            // Trim whitespace from image filenames
            images = images.map(image => image.trim());

            // Limit to three images if there are more
            images = images.slice(0, 3);

            // Update the image paths to point to the uploads folder
            images = images.map(image => '../uploads/' + image);

            // Set the values in the input fields
            document.getElementById('uc_start_date').value = startDate;
            document.getElementById('uc_end_date').value = endDate;

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
                eventDatesContainer.textContent = '';
            } else {
                console.error('Event dates container element not found');
            }

            // Display images in the image section
            var imageContainer = document.getElementById('image');
            if (imageContainer) {
                imageContainer.innerHTML = ''; // Clear previous images

                // Create a row for images
                var imageRow = document.createElement('div');
                imageRow.classList.add('image-row');

                // Iterate through the first three images
                for (var i = 0; i < images.length; i++) {
                    var imgElement = document.createElement('img');
                    imgElement.src = images[i];
                    imgElement.alt = 'Calendar Image';
                    imgElement.classList.add('calendar-image');
                    imageRow.appendChild(imgElement);
                }
                imageContainer.appendChild(imageRow);
            } else {
                console.error('Image container element not found');
            }

            // Call the generateCalendar function and pass the event dates and details
            if (typeof generateCalendar === "function") {
                generateCalendar(eventDates, eventDetails);
            }
        }
    </script>
</head>

<body onload="set_cal_months()">
    <div class="hide-on-print">
        <?php
        // include "../nav/sidebar.php";
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
                    <button type="button" class="btn button ok" id="btnID" onclick="generateCalendar()" disabled><strong>Generate Calendar</strong></button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid ">

        <div id="p1" class="bg-img">
            <div class="d-flex">
                <div id="year-header">

                </div>
                <div id="page-header">

                </div>
            </div>
            <div id="image">
                <!-- Images will be inserted here by JavaScript -->
            </div>
            <div id="uc_message"></div>
            <br><br>

            <div id="calendar"></div>

            <div class="footer">
                <div id="uc_event_dates" style="font-size: 16px; color: black;"></div>
                <div id="page-footer"></div>
            </div>




            <button class="btn btn-primary hide-on-print" style=" margin-left: 45%;margin-top:30px; display: none;" id="button-dis" onclick="printCalendar()">Print Calendar</button>
        </div>

    </div>

    <script>
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const calendar = document.getElementById('calendar');
        const startDateInput = document.getElementById('uc_start_date');
        const endDateInput = document.getElementById('uc_end_date');

        function generateCalendar(eventDates = [], eventDetails = []) {
            // Add image on calendar top 
            document.getElementById('image').style.display = "block";

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

            // Add year header
            document.getElementById('year-header').textContent = currentYear;

            // Generate calendar for each month within the date range
            while (startDate <= endDate && monthCount < 12) {
                const month = startDate.getMonth();
                const year = startDate.getFullYear();

                // Add new year header if the year changes
                if (year !== currentYear) {
                    currentYear = year;
                    addYearHeader(currentYear);
                }

                const monthDiv = document.createElement('div');
                monthDiv.classList.add('month');
                monthDiv.innerHTML = `
                    <h4 style="color:black;">${months[month]} ${year}</h4>
                    <table class="bg_img ">
                        <thead>
                            <tr style="text-align: center;" >
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th style="color:blue;">Sat</th>
                                <th style="color:red;">Sun</th>
                            </tr>
                        </thead>
                        <tbody id="month${month + 1}_${year}"></tbody>
                    </table>
                `;
                calendar.appendChild(monthDiv);
                populateDays(month + 1, year, eventDates, eventDetails);

                // Move to next month
                startDate.setMonth(startDate.getMonth() + 1);
                monthCount++;
            }
        }

        function addYearHeader(year) {
            const yearHeader = document.createElement('div');
            yearHeader.classList.add('year-header');
            yearHeader.textContent = year;
            calendar.appendChild(yearHeader);
        }

        function populateDays(month, year, eventDates, eventDetails) {
            const monthBody = document.getElementById(`month${month}_${year}`);
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
                                cell.innerHTML = `${dayCount} <i class="bi bi-cake" style="color: red;"></i>`; // Add birthday icon
                                cell.classList.add('highlight');

                                // Add event details to the footer for the respective month
                                const eventIndices = [];
                                formattedEventDates.forEach((date, index) => {
                                    if (date === currentDate) {
                                        eventIndices.push(index);
                                    }
                                });
                                const eventFooter = document.getElementById('uc_event_dates');
                                eventIndices.forEach(index => {
                                    const eventDetail = eventDetails[index];
                                    eventFooter.innerHTML += `<p> Event Date :- ${currentDate}: ${eventDetail}</p>`;
                                });
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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>