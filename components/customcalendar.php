<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom DateTime Picker</title>
    <style>
        #calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            max-width: 350px;
            padding: 10px;
        }

        .day {
            padding: 10px;
            background: #f0f0f0;
            cursor: pointer;
            text-align: center;
            border-radius: 5px;
        }

        .selected {
            background: #007bff;
            color: white;
        }

        #time {
            max-height: 100px;
            /* Adjust this value as needed */
            overflow-y: auto;
            font-size: 14px;
            /* Reduce font size if necessary */
        }

        #time option.disabled {
            color: gray;
            background: #d3d3d3;
        }

        #time option.closed {
            color: red;
            background: #ffcccc;
        }

        #time option.minimum-hours {
            color: gray;
            background: #ffffcc;
        }
    </style>
</head>

<body>
    <div id="datetimeselector"
        class="z-50 fixed overflow-hidden hidden inset-0 bg-black bg-opacity-40 items-center justify-center ">
        <div class="bg-white w-fit p-6 rounded-lg shadow-lg flex flex-col gap-2 items-center">
            <h2 class="font-semibold text-xl">CHECK-IN DATE AND TIME</h2>


            <!-- add legend red for closed date and time gray for booked date and time -->

            <div class="flex flex-col gap-3 text-sm my-2">
                <div class="flex items-center gap-1"> <span class="w-4 h-4 bg-red-500 inline-block"></span>
                    <span>Unavailable (Booked)</span>
                </div>
                <div class="flex items-center gap-1"> <span class="w-4 h-4 bg-gray-300 inline-block"></span> <span>Not
                        Available (Closed)</span> </div>
                <div class="flex items-center gap-1"> <span class="w-4 h-4 bg-yellow-300 inline-block"></span>
                    <span>Below Minimum Required Hours</span>
                </div>
            </div>

            <input type="month" id="monthPicker" class="border-2 w-full p-3 rounded-md">
            <div id="calendar" class="border-2 rounded-md"></div>

            <div id="timeSelector">
                <label for="time" class="text-sm">SELECT TIME:</label>
                <select id="time">
                    <!-- Time options will be generated dynamically -->
                </select>
            </div>
            <p><span class="font-semibold">Selected Date & Time:</span> <span id="selectedDateTime">None</span></p>
        </div>
    </div>

    <script>
        // Define booked time slots in the format you provided
        const bookedSlots = <?php echo json_encode($bookedDate, JSON_HEX_TAG); ?>;
        const closedSlots = <?php echo json_encode($closedDateTime, JSON_HEX_TAG); ?>;
        const minimumHours = <?php echo $venue['min_time'] ?? 0; ?>;

        let selectedDate = null;

        function meetsMinimumHours(date, time) {
            let [hour, minute] = time.split(":").map(Number);
            let totalMinutes = hour * 60 + minute;

            for (let i = 1; i < minimumHours * 60; i++) {
                let nextMinutes = totalMinutes + i;
                let nextHour = Math.floor(nextMinutes / 60);
                let nextMinute = nextMinutes % 60;
                let nextTime = `${String(nextHour).padStart(2, "0")}:${String(nextMinute).padStart(2, "0")}`;

                if (isTimeDisabled(date, nextTime) || isClosed(nextTime)) {
                    return false;
                }
            }
            return true;
        }

        function isTimeDisabled(date, time) {
            return bookedSlots.some(slot => {
                let start = new Date(slot.startdate.replace(" ", "T")); // Fix key names
                let end = new Date(slot.enddate.replace(" ", "T"));     // Fix key names
                let selectedDateTime = new Date(`${date}T${time}:00`);

                return selectedDateTime >= start && selectedDateTime <= end;
            });
        }

        function isClosed(time) {
            let closingTime = closedSlots.closing_time; // "22:00:00"
            let openingTime = closedSlots.opening_time; // "08:00:00"

            return time < openingTime || time >= closingTime;
        }


        function generateTimeOptions(date) {
            let timeSelect = document.getElementById("time");
            timeSelect.innerHTML = "";
            let firstValidTime = null;

            for (let h = 0; h < 24; h++) {
                for (let m = 0; m < 60; m += 1) {
                    let hour = String(h).padStart(2, "0");
                    let minute = String(m).padStart(2, "0");
                    let timeValue = `${hour}:${minute}`;

                    let option = document.createElement("option");
                    option.value = timeValue;
                    option.textContent = timeValue;

                    if (isTimeDisabled(date, timeValue)) {
                        option.classList.add("disabled");
                        option.disabled = true;
                    } else if (isClosed(timeValue)) {
                        option.classList.add("closed");
                        option.disabled = true;
                    } else if (!meetsMinimumHours(date, timeValue)) {
                        option.classList.add("minimum-hours");
                        option.disabled = true;
                    } else if (!firstValidTime) {
                        firstValidTime = timeValue;
                    }

                    timeSelect.appendChild(option);
                }
            }

            if (firstValidTime) {
                timeSelect.value = firstValidTime;
                updateSelectedDateTime();
            }
        }

        function generateCalendar(year, month) {
            let calendarEl = document.getElementById("calendar");
            calendarEl.innerHTML = "";
            let firstDay = new Date(year, month, 1).getDay();
            let lastDate = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                let emptyDiv = document.createElement("div");
                calendarEl.appendChild(emptyDiv);
            }

            for (let day = 1; day <= lastDate; day++) {
                let dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
                let dayEl = document.createElement("div");
                dayEl.classList.add("day");
                dayEl.innerText = day;

                dayEl.addEventListener("click", function () {
                    document.querySelectorAll(".day").forEach(el => el.classList.remove("selected"));
                    this.classList.add("selected");
                    selectedDate = dateStr;
                    generateTimeOptions(selectedDate);
                    updateSelectedDateTime();
                });

                calendarEl.appendChild(dayEl);
            }
        }

        function updateSelectedDateTime() {
            let timeInput = document.getElementById("time").value;
            let displayEl = document.getElementById("selectedDateTime");

            if (selectedDate && timeInput) {
                displayEl.innerText = `${selectedDate} ${timeInput}`;
                document.getElementById("checkin").value = `${selectedDate} ${timeInput}`;
            }
        }

        document.getElementById("time").addEventListener("change", updateSelectedDateTime);
        document.getElementById("monthPicker").addEventListener("change", function () {
            let [year, month] = this.value.split("-").map(Number);
            generateCalendar(year, month - 1);
        });

        let today = new Date();
        document.getElementById("monthPicker").value = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, "0")}`;
        generateCalendar(today.getFullYear(), today.getMonth());
    </script>
</body>

</html>