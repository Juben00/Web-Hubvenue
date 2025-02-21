<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Your Venue - HubVenue</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="icon" href="./images/black_ico.png">
    <link rel="stylesheet" href="./output.css">

    <style>
        /* General styling for the label */
        label {
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        label:hover {
            border-color: black;
        }

        label:focus-within {
            outline: none;
            ring: 2px solid black;
        }

        input[type="checkbox"] {
            display: none;
        }

        input[type="checkbox"]:checked+svg {
            fill: #3490dc;
            transition: fill 0.3s ease;
        }

        input[type="checkbox"]:checked+span {
            font-weight: bold;
        }

        label.peer-checked {
            color: #3490dc;
            border-color: black;
            border-width: 2px;
        }

        label.transition {
            transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
        }

        /* On hover state */
        label:hover {
            transform: scale(1.02);
            /* Slightly enlarge on hover */
        }

        body {
            font-family: Arial, sans-serif;
        }

        .step {
            display: none;
            opacity: 0;
            transform: translateX(20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .step.active {
            display: block;
            opacity: 1;
            transform: translateX(0);
        }

        .step.exit {
            opacity: 0;
            transform: translateX(-20px);
        }

        .progress-bar {
            height: 4px;
            background-color: #dddddd;
        }

        .progress {
            height: 100%;
            background-color: #000000;
            transition: width 0.3s ease;
        }

        .custom-checkbox {
            width: 24px;
            height: 24px;
            border: 2px solid #000;
            border-radius: 4px;
            display: inline-block;
            position: relative;
        }

        .custom-checkbox::after {
            content: '\2714';
            font-size: 20px;
            position: absolute;
            top: -2px;
            left: 3px;
            display: none;
        }

        input:checked+.custom-checkbox::after {
            display: block;
        }

        /* input {
            background: transparent;
        } */

        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background-color: white;
            border-bottom: none;
        }
    </style>
    <script>
        let map;
        let marker;
    </script>
    <style>
        #map {
            height: 250px;
            width: 100%;
        }
    </style>
</head>

<body class="bg-slate-50">
    <?php
    // Check if the 'user' key exists in the session
    if (isset($_SESSION['user'])) {
        include_once './components/navbar.logged.in.php';
    } else {
        include_once './components/navbar.html';
    }

    include_once './components/SignupForm.html';
    include_once './components/feedback.modal.html';
    include_once './components/confirm.feedback.modal.html';
    include_once './components/Menu.html';

    ?>
    <div class="mb-12 mx-auto px-4 py-8 max-w-3xl pt-28 pb-16">
        <?php require_once './spinner.php'; ?>

        <form id="add-venue-form" class="" enctype="multipart/form-data" multiple> <!-- Adjusted max-width -->
            <div id="step1" class="step active">
                <h2 class="text-3xl font-semibold mb-2">Step 1</h2>
                <h1 class="text-4xl font-bold mb-4">Tell us about your place</h1>
                <p class="text-xl text-gray-600 mb-8">In this step, we'll ask you which type of property you have and if
                    guests will book the entire place or just a room. Then let us know the location and how many guests
                    can
                    stay.</p>
            </div>

            <div id="step2" class="step">
                <h2 class="text-3xl font-semibold mb-4">Which of these best describes your place?</h2>
                <div class="grid grid-cols-2 gap-4">
                    <label
                        class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black cursor-pointer peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input type="radio" name="placeType" value="Corporate Space" class="placeType hidden peer">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <h3 class="font-semibold">Corporate Space</h3>
                        <p class="text-sm text-gray-500">Professional venue for meetings, conferences and business
                            events
                        </p>
                    </label>

                    <label
                        class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black cursor-pointer peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input type="radio" name="placeType" value="Reception Hall" class="placeType hidden peer">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 15.5458C21 19.5458 12 23.5458 12 23.5458C12 23.5458 3 19.5458 3 15.5458V8.54578C3 7.71778 3.543 6.97178 4.316 6.67278L11.316 4.17278C11.756 4.01978 12.244 4.01978 12.684 4.17278L19.684 6.67278C20.457 6.97178 21 7.71778 21 8.54578V15.5458Z">
                            </path>
                        </svg>
                        <h3 class="font-semibold">Reception Hall</h3>
                        <p class="text-sm text-gray-500">Large spaces perfect for weddings, parties and formal
                            gatherings
                        </p>
                    </label>

                    <label
                        class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black cursor-pointer peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input type="radio" name="placeType" value="Intimate Space" class="placeType hidden peer">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <h3 class="font-semibold">Intimate Space</h3>
                        <p class="text-sm text-gray-500">Cozy venues ideal for small gatherings and private events</p>
                    </label>

                    <label
                        class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black cursor-pointer peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input type="radio" name="placeType" value="Outdoor Venue" class="placeType hidden peer">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                            </path>
                        </svg>
                        <h3 class="font-semibold">Outdoor Venue</h3>
                        <p class="text-sm text-gray-500">Beautiful outdoor spaces for events under the sky</p>
                    </label>
                </div>
            </div>

            <div id="step3" class="step">
                <h1 class="text-3xl font-bold mb-4">Tell guests what your place has to offer</h1>
                <p class="text-gray-600 mb-6">You can add more amenities after you publish your listing.</p>

                <!-- guest favorite -->
                <div class="flex justify-between w-full items-center mb-4">
                    <h2 class="text-xl font-semibold ">What about these guest favorites?</h2>
                    <label for="firstCategoryButton" id="firstCategoryButtonLabel"
                        class="flex items-center border duration-150 text-xs border-gray-800 rounded-full py-1 px-3 gap-2 cursor-pointer text-gray-700 hover:text-gray-900 focus-within:text-gray-900">
                        <input type="checkbox" id="firstCategoryButton">
                        <span class="font-medium duration-150" id="firstCategoryLabel">Select all</span>
                    </label>
                </div>
                <div class="grid grid-cols-4 gap-4 mb-8">
                    <label for="Wifi"
                        class="firstCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Wifi" class="amenityItem" type="checkbox" name="amenities[]" value="Wifi"
                            class="hidden peer">
                        <svg class="w-12 h-12 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M16 20a4 4 0 1 1 0 8 4 4 0 0 1 0-8zm0 2a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm0-7a9 9 0 1 1 0 18 9 9 0 0 1 0-18zm0 2a7 7 0 1 0 0 14 7 7 0 0 0 0-14zm0-13a9 9 0 1 1 0 18 9 9 0 0 1 0-18zm0 2a7 7 0 1 0 0 14 7 7 0 0 0 0-14z">
                            </path>
                        </svg>
                        <span class="block">Wifi</span>
                    </label>

                    <label for="TV"
                        class=" firstCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-blue-300 peer-checked:border-black transition">
                        <input id="TV" class="amenityItem" type="checkbox" name="amenities[]" value="TV"
                            class="hidden peer">
                        <svg width="64px" height="64px" viewBox="-8.4 -8.4 40.80 40.80" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M21.0254 8.40554C20.7987 8.20998 20.5218 8.09678 20.3141 8.02584C20.0833 7.94703 19.8184 7.88184 19.5383 7.82624C18.9764 7.71473 18.2727 7.62624 17.4908 7.55704C15.9221 7.41822 13.955 7.34998 12 7.34998C10.045 7.34997 8.0779 7.41821 6.50923 7.55704C5.7273 7.62623 5.02357 7.71473 4.46174 7.82624C4.18161 7.88184 3.91672 7.94703 3.68594 8.02583C3.4782 8.09677 3.20126 8.20998 2.97462 8.40553C2.76112 8.58976 2.63916 8.81815 2.56971 8.97159C2.49263 9.14189 2.43333 9.32752 2.38581 9.50895C2.29052 9.87283 2.21854 10.3144 2.16365 10.7872C2.05319 11.7386 2 12.9242 2 14.1032C2 15.283 2.05326 16.4858 2.16311 17.4726C2.21784 17.9643 2.28883 18.4229 2.38053 18.807C2.46043 19.1416 2.59126 19.5854 2.85131 19.906C3.08981 20.2 3.43086 20.3352 3.60561 20.3981C3.82965 20.4789 4.09015 20.5429 4.36115 20.596C4.90739 20.703 5.60964 20.7873 6.39637 20.853C7.97657 20.9851 9.99449 21.05 12 21.05C14.0055 21.05 16.0234 20.9851 17.6036 20.853C18.3904 20.7873 19.0926 20.703 19.6388 20.596C19.9098 20.5429 20.1703 20.4789 20.3944 20.3981C20.5691 20.3352 20.9102 20.2 21.1487 19.906C21.4087 19.5854 21.5396 19.1416 21.6195 18.807C21.7112 18.4229 21.7822 17.9643 21.8369 17.4726C21.9467 16.4858 22 15.283 22 14.1032C22 12.9242 21.9468 11.7386 21.8363 10.7872C21.7815 10.3144 21.7095 9.87284 21.6142 9.50896C21.5667 9.32752 21.5074 9.14189 21.4303 8.9716C21.3608 8.81815 21.2389 8.58976 21.0254 8.40554Z"
                                    stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <line x1="11.4858" y1="6.44995" x2="8.39999" y2="3.36416" stroke="#333333"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></line>
                                <line x1="1" y1="-1" x2="5.36396" y2="-1"
                                    transform="matrix(0.707107 -0.707107 -0.707107 -0.707107 11.1 6.44995)"
                                    stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                </line>
                            </g>
                        </svg>

                        <span class="block">TV</span>
                    </label>

                    <label for="Kitchen"
                        class=" firstCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Kitchen" class="amenityItem" type="checkbox" name="amenities[]" value="Kitchen"
                            class="hidden peer">
                        <svg fill="#000000" width="64px" height="64px" viewBox="-16.83 -16.83 81.75 81.75"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            data-name="Слой 1">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M9 0 A 1.0001 1.0001 0 0 0 8 1L8 4.484375L1.4179688 9.1855469 A 1.0001 1.0001 0 0 0 1 10L1 14 A 1.0001 1.0001 0 0 0 2 15L24 15 A 1.0001 1.0001 0 0 0 25 14L25 10 A 1.0001 1.0001 0 0 0 24.582031 9.1855469L18 4.4863281L18 1 A 1.0001 1.0001 0 0 0 17 0L9 0 z M 10 2L16 2L16 5 A 1.0001 1.0001 0 0 0 16.417969 5.8144531L23 10.513672L23 13L3 13L3 10.513672L9.5820312 5.8144531 A 1.0001 1.0001 0 0 0 10 5L10 2 z M 5.5 21C4.8457598 21 4.2978026 21.418077 4.0917969 22L1 22 A 1.0001 1.0001 0 0 0 0 23L0 45 A 1.0001 1.0001 0 0 0 1 46L47.095703 46 A 1.0001 1.0001 0 0 0 48.095703 45L48.095703 23 A 1.0001 1.0001 0 0 0 47.095703 22L21.908203 22C21.702197 21.418077 21.15424 21 20.5 21L5.5 21 z M 2 24L5.5 24L20.5 24L24.095703 24L24.095703 44L2 44L2 24 z M 26.095703 24L46.095703 24L46.095703 30L26.095703 30L26.095703 24 z M 5 26 A 1.0001 1.0001 0 0 0 4 27L4 41 A 1.0001 1.0001 0 0 0 5 42L21 42 A 1.0001 1.0001 0 0 0 22 41L22 27 A 1.0001 1.0001 0 0 0 21 26L5 26 z M 30 26 A 1.0001 1.0001 0 1 0 30 28L42 28 A 1.0001 1.0001 0 1 0 42 26L30 26 z M 6 28L20 28L20 40L6 40L6 28 z M 26.095703 32L46.095703 32L46.095703 44L26.095703 44L26.095703 32 z M 29.984375 34.986328 A 1.0001 1.0001 0 0 0 29 36L29 41 A 1.0001 1.0001 0 1 0 31 41L31 36 A 1.0001 1.0001 0 0 0 29.984375 34.986328 z">
                                </path>
                            </g>
                        </svg>

                        <span class="block">Kitchen</span>
                    </label>

                    <label for="Free parking on premises"
                        class=" firstCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Free parking on premises" class="amenityItem" type="checkbox" name="amenities[]"
                            value="Free parking on premises" class="hidden peer">
                        <svg width="64px" height="64px" viewBox="-21.21 -21.21 103.02 103.02" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#"
                            xmlns:dc="http://purl.org/dc/elements/1.1/"
                            xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <metadata>
                                    <rdf:rdf>
                                        <cc:work rdf:about="">
                                            <dc:format>image/svg+xml</dc:format>
                                            <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"></dc:type>
                                            <dc:title></dc:title>
                                            <dc:source>http://www.mlit.go.jp/common/001245686.pdf</dc:source>
                                        </cc:work>
                                    </rdf:rdf>
                                </metadata>
                                <path
                                    d="m7.7855 56.032c-1.7762 0-3.2162-1.44-3.2162-3.2162v-45.03c0-1.7762 1.44-3.2162 3.2162-3.2162h45.031c1.775 0 3.215 1.44 3.215 3.2162v45.03c0 1.7762-1.44 3.2162-3.215 3.2162h-45.031z"
                                    style="fill:#ffffff;stroke-width:.60625;stroke:#000"></path>
                                <path
                                    d="m43.686 42.623c-1.4462 0-2.6175-1.1738-2.6175-2.6175 0-1.4475 1.1712-2.6188 2.6175-2.6188 1.4438 0 2.6175 1.1712 2.6175 2.6188 0 1.4438-1.1738 2.6175-2.6175 2.6175zm-19.098 0c-1.445 0-2.6175-1.1738-2.6175-2.6175 0-1.4475 1.1725-2.6188 2.6175-2.6188 1.4462 0 2.6175 1.1712 2.6175 2.6188 0 1.4438-1.1712 2.6175-2.6175 2.6175zm0.30375-13.666 0.07875-0.0088c3.03-0.315 6.1138-0.475 9.1662-0.475 3.0538 0 6.1388 0.16 9.17 0.47625l0.07875 0.0087 1.7988 6.26h-22.1l1.8075-6.2612zm21.878 6.2612-2.2-7.665c-3.4212-0.4025-6.9038-0.60875-10.432-0.60875-3.53 0-7.0112 0.20625-10.432 0.60875l-2.2012 7.665c-1.32 0-2.3838 1.07-2.3838 2.39v8.9088h2.3662l-0.0012 3.805c0.57875 0.20875 1.1888 0.325 1.8412 0.325 0.64125 0 1.27-0.11 1.84-0.315v-3.8162l17.94-0.0038v3.81c0.58 0.20875 1.1888 0.325 1.8412 0.325 0.64125 0 1.2688-0.11 1.84-0.315l0.0012-3.82h2.375v-8.9038c0-1.32-1.0725-2.39-2.3938-2.39">
                                </path>
                                <path
                                    d="m16.538 19.054h1.4438c1.9262 0 3.4605-0.69225 3.4605-2.8882 0-2.1367-1.5344-2.8289-3.4605-2.8289h-1.4438zm-5.5965-9.688h6.6792c6.4087 0 9.4175 2.1667 9.4175 6.8897 0 4.2427-3.0987 6.7698-8.3342 6.7698h-2.166v7.3415h-5.5965v-21.001">
                                </path>
                            </g>
                        </svg>

                        <span class="block">Free parking space</span>
                    </label>

                    <label for="Air Conditioned Room"
                        class=" firstCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Air Conditioned Room" class="amenityItem" type="checkbox" name="amenities[]"
                            value="Air Conditioned Room" class="hidden peer">
                        <svg fill="#000000" height="64px" width="64px" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="-103.95 -103.95 504.90 504.90" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path
                                        d="M277.918,180.513c-7.372,1.592-12.059,8.86-10.467,16.233c0.26,1.201,0.561,3.421-0.331,4.777 c-0.719,1.093-2.41,1.97-4.639,2.407c-2.055,0.4-7.165-1.147-11.871-10.151l-24.08-48.084h38.583 c9.879,0,18.948-4.207,24.881-11.411c5.934-7.204,8.253-16.934,6.361-26.631l-8.359-42.916 c-3.577-18.335-21.012-32.773-39.692-32.773H48.696c-18.679,0-36.114,14.42-39.692,32.753l-8.359,42.87 c-1.892,9.695,0.427,19.478,6.361,26.682c5.933,7.203,15.002,11.425,24.881,11.425h37.712l-24.08,48.083 c-4.708,9.008-9.836,10.591-11.871,10.19c-2.23-0.437-3.921-1.333-4.64-2.426c-0.893-1.356-0.591-3.585-0.331-4.786 c1.592-7.372-3.094-14.645-10.467-16.237c-7.375-1.598-14.64,3.092-16.233,10.464c-2.039,9.438-0.58,18.277,4.217,25.562 c4.795,7.284,12.679,12.323,22.198,14.189c1.871,0.367,3.849,0.565,5.902,0.565c11.74-0.001,25.848-6.496,35.508-25.089 c0.032-0.064,0.065-0.05,0.096-0.114l30.239-60.402h34.395v74.672l-8.134-7.585c-5.563-5.093-14.125-4.71-19.218,0.855 c-5.093,5.564-4.671,14.203,0.893,19.295l31.186,28.523c2.612,2.39,5.925,3.583,9.229,3.583c3.385,0,6.773-1.252,9.405-3.749 l30.074-28.523c5.472-5.19,5.702-13.835,0.511-19.307c-5.19-5.473-13.679-5.7-19.152-0.51l-6.86,6.654v-73.907h33.524 l30.238,60.402c0.032,0.064,0.065,0.089,0.097,0.152c9.661,18.593,23.767,25.07,35.508,25.07c2.052,0,4.031-0.208,5.901-0.575 c9.519-1.866,17.403-6.91,22.198-14.195c4.796-7.285,6.255-16.128,4.217-25.566C292.56,183.609,285.291,178.931,277.918,180.513z M28.088,116.607c-0.737-0.895-0.961-2.196-0.633-3.876l8.359-43.03C36.878,64.247,43.138,58.9,48.696,58.9h199.608 c5.558,0,11.818,5.405,12.882,10.86l8.359,42.962c0.328,1.682,0.104,2.928-0.633,3.822c-0.737,0.895-2.086,1.216-3.799,1.216 H31.887C30.173,117.76,28.824,117.501,28.088,116.607z">
                                    </path>
                                    <path
                                        d="M233.596,75.86h-22.062c-7.543,0-13.657,6.424-13.657,13.967c0,7.543,6.115,13.967,13.657,13.967h22.062 c7.543,0,13.657-6.424,13.657-13.967C247.254,82.284,241.139,75.86,233.596,75.86z">
                                    </path>
                                </g>
                            </g>
                        </svg>

                        <span class="block">Air Conditioned Room</span>
                    </label>

                    <label for="CCTV Cameras"
                        class=" firstCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="CCTV Cameras" class="amenityItem" type="checkbox" name="amenities[]"
                            value="CCTV Cameras" class="hidden peer">
                        <svg fill="#000000" width="64px" height="64px" viewBox="-11.2 -11.2 54.40 54.40" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <title>cctv</title>
                                <path
                                    d="M30.65 15.016c-0.070-0.189-0.208-0.338-0.384-0.421l-0.005-0.002-2.218-1.034 0.601-1.289c0.045-0.093 0.071-0.202 0.071-0.318 0-0.299-0.176-0.558-0.429-0.678l-0.005-0.002-21.254-9.911c-0.093-0.045-0.202-0.071-0.318-0.071-0.299 0-0.557 0.175-0.677 0.428l-0.002 0.005-4.589 9.842c-0.044 0.093-0.070 0.202-0.070 0.317 0 0.299 0.175 0.557 0.428 0.678l0.005 0.002 8.212 3.829-2.51 5.859h-4.756v-4.25c0-0.414-0.336-0.75-0.75-0.75s-0.75 0.336-0.75 0.75v0 10c0 0.414 0.336 0.75 0.75 0.75s0.75-0.336 0.75-0.75v0-4.25h5.25c0.307-0 0.572-0.186 0.688-0.45l0.002-0.005 2.687-6.269 11.682 5.447c0.091 0.044 0.198 0.070 0.311 0.070 0.002 0 0.003 0 0.005-0h-0c0.299-0 0.558-0.175 0.678-0.429l0.002-0.005 0.6-1.287 2.22 1.035c0.091 0.044 0.198 0.070 0.311 0.070 0.002 0 0.003 0 0.005-0h-0c0.299-0 0.558-0.175 0.678-0.429l0.002-0.005 2.754-5.904c0.044-0.093 0.070-0.202 0.070-0.318 0-0.092-0.017-0.18-0.047-0.262l0.002 0.005zM23.012 20.797l-11.615-5.417c-0.030-0.025-0.062-0.048-0.097-0.068l-0.003-0.002c-0.024-0.007-0.054-0.013-0.084-0.018l-0.004-0-8.090-3.773 3.955-8.482 19.896 9.276-1.047 2.244zM26.828 20.182l-1.539-0.719 0.176-0.377 1.945-4.167 1.539 0.717z">
                                </path>
                            </g>
                        </svg>

                        <span class="block">CCTV Cameras</span>
                    </label>

                    <label for="Dedicated workspace"
                        class="firstCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Dedicated workspace" class="amenityItem" type="checkbox" name="amenities[]"
                            value="Dedicated workspace" class="hidden peer">
                        <svg fill="#000000" height="64px" width="64px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="-137.41 -137.41 667.42 667.42" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <g>
                                        <path
                                            d="M346.634,212.816h-37.689c-4.267-43.442-33.422-81.196-75.184-95.935c-5.107-1.745-10.796,0.453-13.317,5.301l-22.95,44.8 l-23.273-45.511c-2.457-4.784-8.016-7.111-13.123-5.43c-43.119,14.158-73.115,52.17-77.382,96.582H45.899 c-6.012,0-10.925,4.848-10.925,10.925v134.982c0,6.012,4.848,10.925,10.925,10.925h16.226v12.218 c0,6.012,4.849,10.925,10.925,10.925c6.077,0,10.925-4.849,10.925-10.925v-12.218h224.646v12.218 c0,6.012,4.849,10.925,10.925,10.925c6.012,0,10.925-4.849,10.925-10.925v-12.218h16.226c6.012,0,10.925-4.848,10.925-10.925 V223.677C357.56,217.665,352.582,212.816,346.634,212.816z M159.224,140.218l28.509,55.79c1.875,3.62,5.624,5.948,9.762,5.948 c4.073,0,7.887-2.327,9.762-5.948l28.057-54.949c28.444,13.446,47.968,40.663,51.717,71.693H105.568 C109.382,180.881,129.746,153.277,159.224,140.218z M335.774,347.539h-0.129v0.129H56.889v-24.954h14.869 c6.012,0,10.925-4.848,10.925-10.925c0-6.012-4.849-10.925-10.925-10.925H56.889v-19.394h40.598 c6.012,0,10.925-4.849,10.925-10.925c0-6.012-4.848-10.925-10.925-10.925H56.889v-24.953h278.885V347.539z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M196.267,0c-26.764,0-48.42,21.721-48.42,48.42c0,26.699,21.657,48.485,48.42,48.485s48.42-21.721,48.42-48.42 C244.687,21.786,223.03,0,196.267,0z M196.267,75.055c-14.675,0-26.634-11.96-26.634-26.634s11.96-26.634,26.634-26.634 s26.634,11.96,26.634,26.634S210.941,75.055,196.267,75.055z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>

                        <span class="block">Dedicated workspace</span>
                    </label>
                </div>

                <!-- standout amenities -->
                <div class="flex justify-between w-full items-center mb-4">
                    <h2 class="text-xl font-semibold mb-4">Do you have any standout amenities?</h2>
                    <label for="secondCategoryButton" id="secondCategoryButtonLabel"
                        class="flex items-center border duration-150 text-xs border-gray-800 rounded-full py-1 px-3 gap-2 cursor-pointer text-gray-700 hover:text-gray-900 focus-within:text-gray-900">
                        <input type="checkbox" id="secondCategoryButton">
                        <span class="font-medium duration-150" id="secondCategoryLabel">Select all</span>
                    </label>
                </div>
                <div class="grid grid-cols-4 gap-4 mb-8">

                    <label for="Pool"
                        class="p-4 border secondCategory rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Pool" type="checkbox" class="amenityItem" name="amenities[]" value="Pool"
                            class="hidden peer">
                        <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M24 26c.988 0 1.945.351 2.671 1.009.306.276.71.445 1.142.483L28 27.5v2l-.228-.006a3.96 3.96 0 0 1-2.443-1.003A1.978 1.978 0 0 0 24 28c-.502 0-.978.175-1.328.491a3.977 3.977 0 0 1-2.67 1.009 3.977 3.977 0 0 1-2.672-1.009A1.978 1.978 0 0 0 16 28c-.503 0-.98.175-1.329.491a3.978 3.978 0 0 1-2.67 1.009 3.978 3.978 0 0 1-2.672-1.009A1.978 1.978 0 0 0 8 28c-.503 0-.98.175-1.33.491a3.96 3.96 0 0 1-2.442 1.003L4 29.5v-2l.187-.008a1.953 1.953 0 0 0 1.142-.483A3.975 3.975 0 0 1 8 26c.988 0 1.945.352 2.671 1.009.35.316.826.491 1.33.491.502 0 .979-.175 1.328-.491A3.974 3.974 0 0 1 16 26c.988 0 1.945.351 2.671 1.009.35.316.826.491 1.33.491.502 0 .979-.175 1.328-.491A3.975 3.975 0 0 1 24 26zm0-5c.988 0 1.945.351 2.671 1.009.306.276.71.445 1.142.483L28 22.5v2l-.228-.006a3.96 3.96 0 0 1-2.443-1.003A1.978 1.978 0 0 0 24 23c-.502 0-.978.175-1.328.491a3.977 3.977 0 0 1-2.67 1.009 3.977 3.977 0 0 1-2.672-1.009A1.978 1.978 0 0 0 16 23c-.503 0-.98.175-1.329.491a3.978 3.978 0 0 1-2.67 1.009 3.978 3.978 0 0 1-2.672-1.009A1.978 1.978 0 0 0 8 23c-.503 0-.98.175-1.33.491a3.96 3.96 0 0 1-2.442 1.003L4 24.5v-2l.187-.008a1.953 1.953 0 0 0 1.142-.483A3.975 3.975 0 0 1 8 21c.988 0 1.945.352 2.671 1.009.35.316.826.491 1.33.491.502 0 .979-.175 1.328-.491A3.974 3.974 0 0 1 16 21c.988 0 1.945.351 2.671 1.009.35.316.826.491 1.33.491.502 0 .979-.175 1.328-.491A3.975 3.975 0 0 1 24 21zm0-5c.988 0 1.945.351 2.671 1.009.306.276.71.445 1.142.483L28 17.5v2l-.228-.006a3.96 3.96 0 0 1-2.443-1.003A1.978 1.978 0 0 0 24 18c-.502 0-.978.175-1.328.491a3.977 3.977 0 0 1-2.67 1.009 3.977 3.977 0 0 1-2.672-1.009A1.978 1.978 0 0 0 16 18c-.503 0-.98.175-1.329.491a3.978 3.978 0 0 1-2.67 1.009 3.978 3.978 0 0 1-2.672-1.009A1.978 1.978 0 0 0 8 18c-.503 0-.98.175-1.33.491a3.96 3.96 0 0 1-2.442 1.003L4 19.5v-2l.187-.008a1.953 1.953 0 0 0 1.142-.483A3.975 3.975 0 0 1 8 16c.988 0 1.945.352 2.671 1.009.35.316.826.491 1.33.491.502 0 .979-.175 1.328-.491A3.974 3.974 0 0 1 16 16c.988 0 1.945.351 2.671 1.009.35.316.826.491 1.33.491.502 0 .979-.175 1.328-.491A3.975 3.975 0 0 1 24 16z">
                            </path>
                        </svg>
                        <span class="block">Pool</span>
                    </label>

                    <label for="Hot tub"
                        class="p-4 border secondCategory  rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Hot tub" type="checkbox" class="amenityItem" name="amenities[]" value="Hot tub"
                            class="hidden peer">
                        <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M9.5 2a4.5 4.5 0 0 1 3.527 7.295c.609.215 1.173.55 1.66.988l.191.182L17.414 13H31v2h-2v14a2 2 0 0 1-1.85 1.995L27 31H5a2 2 0 0 1-1.995-1.85L3 29V15H1v-2h2.1a5.009 5.009 0 0 1 2.955-3.608A4.5 4.5 0 0 1 9.5 2zm7.5 13H5v14h22V15h-10.1l2.1 2.1-1.4 1.4-4.1-4.1zm-7.5-11a2.5 2.5 0 0 0-1.849 4.18l.137.143.114.103a4.99 4.99 0 0 1 3.096-.425A2.5 2.5 0 0 0 9.5 4z">
                            </path>
                        </svg>
                        <span class="block">Hot tub</span>
                    </label>

                    <label for="Patio"
                        class=" secondCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Patio" type="checkbox" class="amenityItem" name="amenities[]" value="Patio"
                            class="hidden peer">
                        <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M23 1a2 2 0 0 1 1.995 1.85L25 3v16h4v2h-2v8h-2v-8h-4v-2h4V3h-2V1zM9 1a2 2 0 0 1 1.995 1.85L11 3v16h4v2h-4v8H9v-8H5v-2h4V3H7V1zm14 2H9v15h14zm-7 8a1 1 0 1 1 0 2 1 1 0 0 1 0-2z">
                            </path>
                        </svg>
                        <span class="block">Patio</span>
                    </label>

                    <label for="BBQ grill"
                        class=" secondCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="BBQ grill" type="checkbox" class="amenityItem" name="amenities[]" value="BBQ grill"
                            class="hidden peer">
                        <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M12.994 2h2c-.002 2.062-.471 3.344-1.765 5.424l-.753 1.183c-.867 1.391-1.278 2.301-1.418 3.393H9.043c.1-1.069.378-1.966.903-3H6c0 5.523 4.477 10 10 10 5.43 0 9.848-4.327 9.996-9.72L26 9l-3.765.001c-.704 1.177-1.05 2.014-1.177 2.999h-2.015c.15-1.613.708-2.836 1.91-4.728l.563-.88c1.116-1.791 1.477-2.784 1.478-4.393h2c-.002 1.919-.408 3.162-1.506 5L28 7v2c0 .682-.057 1.35-.166 2H30v2h-2.683a12.039 12.039 0 0 1-5.896 6.709l4.49 9.877-1.821.828-2.006-4.415H17V30h-2v-4H9.916L7.91 30.415l-1.821-.828 4.49-9.877A12.039 12.039 0 0 1 4.682 13H2v-2h2.166a12.058 12.058 0 0 1-.162-1.695L4 9V7l7.298.001c-1.1-1.84-1.506-3.064-1.506-4.984V2h.389c1.296 0 2.041.26 3.537 1.603l.726.654c1.639 1.479 2.342 2.481 2.548 4.743H12.994z">
                            </path>
                        </svg>
                        <span class="block">BBQ grill</span>
                    </label>

                    <label for="Outdoor dining are"
                        class=" secondCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Outdoor dining are" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Outdoor dining area" class="hidden peer">
                        <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M29 15v16h-2v-6h-6v6h-2v-6.333a3.001 3.001 0 0 1-2 0V31h-2v-6h-6v6H7V15H3v-2h2v-2h2V9h2V7h2V5h2V3h10v2h2v2h2v2h2v2h2v2h2v2zM17 3h-2v2h2zm0 4h-2v2h2zm0 4h-2v2h2zm0 4h-2v2h2zM9 19h14v2H9zm14-4H9v2h14z">
                            </path>
                        </svg>
                        <span class="block">Outdoor dining area</span>
                    </label>

                    <label for="Fire pit"
                        class=" secondCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Fire pit" type="checkbox" class="amenityItem" name="amenities[]" value="Fire pit"
                            class="hidden peer">
                        <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M27 3a2 2 0 0 1 1.995 1.85L29 5v6h-2V5h-7v14h7v-5h2v11a2 2 0 0 1-1.85 1.995L27 27h-7v2h-8v-2h-7a2 2 0 0 1-1.995-1.85L3 25V5a2 2 0 0 1 1.85-1.995L5 3zm0 16h-7v6h7zm-16-5a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm0 2a1 1 0 1 0 0 2 1 1 0 0 0 0-2zM5 5v20h7v-6.674a5 5 0 1 1 2 0V25h7V5z">
                            </path>
                        </svg>
                        <span class="block">Fire pit</span>
                    </label>

                    <label for="Pool table"
                        class=" secondCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Pool table" type="checkbox" class="amenityItem" name="amenities[]" value="Pool table"
                            class="hidden peer">
                        <svg width="64px" height="64px" viewBox="0 0 76.50 76.50" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M34.875 12.5C36.049 12.5 37 13.451 37 14.625C37 15.799 36.049 16.75 34.875 16.75C33.701 16.75 32.75 15.799 32.75 14.625C32.75 13.451 33.701 12.5 34.875 12.5Z"
                                    stroke="#3C3C3C" stroke-width="2" stroke-linejoin="round"></path>
                                <path
                                    d="M34.875 28.25C36.049 28.25 37 29.201 37 30.375C37 31.549 36.049 32.5 34.875 32.5C33.701 32.5 32.75 31.549 32.75 30.375C32.75 29.201 33.701 28.25 34.875 28.25Z"
                                    stroke="#3C3C3C" stroke-width="2" stroke-linejoin="round"></path>
                                <path
                                    d="M11.312 27.875C12.589 27.875 13.625 28.911 13.625 30.188C13.625 31.465 12.589 32.5 11.312 32.5C10.035 32.5 9 31.465 9 30.188C9 28.911 10.035 27.875 11.312 27.875Z"
                                    stroke="#3C3C3C" stroke-width="2" stroke-linejoin="round"></path>
                                <path
                                    d="M11.312 12.5C12.589 12.5 13.625 13.535 13.625 14.812C13.625 16.089 12.589 17.125 11.312 17.125C10.035 17.125 9 16.089 9 14.812C9 13.535 10.035 12.5 11.312 12.5Z"
                                    stroke="#3C3C3C" stroke-width="2" stroke-linejoin="round"></path>
                                <path d="M25 32.5V30.5C25 29.395 24.105 28.5 23 28.5C21.895 28.5 21 29.395 21 30.5V32.5"
                                    stroke="#3C3C3C" stroke-width="2" stroke-linejoin="round"></path>
                                <path d="M25 12.5V14.5C25 15.605 24.105 16.5 23 16.5C21.895 16.5 21 15.605 21 14.5V12.5"
                                    stroke="#3C3C3C" stroke-width="2" stroke-linejoin="round"></path>
                                <path d="M9 12.5H37V32.5H9V12.5Z" stroke="#3C3C3C" stroke-width="2"
                                    stroke-linejoin="round"></path>
                                <path d="M25.682 21.548L31 37.5" stroke="#3C3C3C" stroke-width="2"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M25 18.5C25.552 18.5 26 18.948 26 19.5C26 20.052 25.552 20.5 25 20.5C24.448 20.5 24 20.052 24 19.5C24 18.948 24.448 18.5 25 18.5Z"
                                    fill="#3C3C3C"></path>
                            </g>
                        </svg>

                        <span class="block">Pool table</span>
                    </label>

                    <label for="Indoor fireplace"
                        class=" secondCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Indoor fireplace" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Indoor fireplace" class="hidden peer">
                        <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M31 6v2h-1v23h-2V8h-1V6zm-5 16v2h-2v7h-2v-7h-2v-2zM5 14v2H3v10H1V14zm20 5v2h-2v9h-2v-9h-2v-2zm-5-3v2h-2v12h-2V18h-2v-2zm-5-5v2h-2v17h-2V13h-2v-2z">
                            </path>
                        </svg>
                        <span class="block">Indoor fireplace</span>
                    </label>

                    <label for="Piano"
                        class=" secondCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Piano" type="checkbox" class="amenityItem" name="amenities[]" value="Piano"
                            class="hidden peer">
                        <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M9 1v2h14V1h2v2h4v4h2v2h-2v18h-2v-2h-4v2h-2v-2H11v2H9v-2H5v2H3V9H1V7h2V3h4V1zm4 4H9v2H5v18h4v-2h14v2h4V7h-4V5h-4v2h-2V5zm-1 4h12v12H12zm2 2v8h8V9z">
                            </path>
                        </svg>
                        <span class="block">Piano</span>
                    </label>

                    <label for="Exercise equipment"
                        class=" secondCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Exercise equipment" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Exercise equipment" class="hidden peer">
                        <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M20 1v2h-3v2h1a2 2 0 0 1 1.995 1.85L20 7v2a4 4 0 0 1 3.995 3.8L24 13v14a4 4 0 0 1-3.8 3.995L20 31h-8a4 4 0 0 1-3.995-3.8L8 27V13a4 4 0 0 1 3.8-3.995L12 9V7a2 2 0 0 1 1.85-1.995L14 5h1V3h-3V1zm2 21H10v5a2 2 0 0 0 1.697 1.977l.154.018L7 27h18a2 2 0 0 0 1.995-1.85L22 27zm0-6H10v4h12zm-2-5h-8a2 2 0 0 0-1.995 1.85L10 13v1h12v-1a2 2 0 0 0-2-2zm-3-4h-2v2h2z">
                            </path>
                        </svg>
                        <span class="block">Exercise equipment</span>
                    </label>

                    <label for="Karaoke System"
                        class=" secondCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Karaoke System" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Karaoke System" class="hidden peer">
                        <svg fill="#000000" class="w-10 h-10 mb-2" viewBox="0 0 32 32"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M3,21a3.425,3.425,0,0,0,4.61.191l7.258-6.14A6.536,6.536,0,1,0,8.949,9.134L2.81,16.388A3.388,3.388,0,0,0,3,21ZM12.248,5.333a4.539,4.539,0,1,1,0,6.419h0A4.537,4.537,0,0,1,12.248,5.333ZM4.336,17.678l5.27-6.227a6.583,6.583,0,0,0,2.944,2.942L6.321,19.664a1.42,1.42,0,0,1-1.9-.079A1.4,1.4,0,0,1,4.336,17.678Z">
                                </path>
                            </g>
                        </svg>

                        <span class="block">Karaoke System</span>
                    </label>

                    <label for="Sound System"
                        class=" secondCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Sound System" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Sound System" class="hidden peer">
                        <svg class="block" width="64px" height="64px" viewBox="0 0 40.80 40.80" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M12 7H12.01M12.5 7C12.5 7.27614 12.2761 7.5 12 7.5C11.7239 7.5 11.5 7.27614 11.5 7C11.5 6.72386 11.7239 6.5 12 6.5C12.2761 6.5 12.5 6.72386 12.5 7ZM15 14C15 15.6569 13.6569 17 12 17C10.3431 17 9 15.6569 9 14C9 12.3431 10.3431 11 12 11C13.6569 11 15 12.3431 15 14ZM8.2 21H15.8C16.9201 21 17.4802 21 17.908 20.782C18.2843 20.5903 18.5903 20.2843 18.782 19.908C19 19.4802 19 18.9201 19 17.8V6.2C19 5.0799 19 4.51984 18.782 4.09202C18.5903 3.71569 18.2843 3.40973 17.908 3.21799C17.4802 3 16.9201 3 15.8 3H8.2C7.0799 3 6.51984 3 6.09202 3.21799C5.71569 3.40973 5.40973 3.71569 5.21799 4.09202C5 4.51984 5 5.07989 5 6.2V17.8C5 18.9201 5 19.4802 5.21799 19.908C5.40973 20.2843 5.71569 20.5903 6.09202 20.782C6.51984 21 7.07989 21 8.2 21Z"
                                    stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                            </g>
                        </svg>

                        <span class="block">Sound System</span>
                    </label>
                </div>

                <!-- safety Items -->
                <div class="flex justify-between w-full items-center mb-4">
                    <h2 class="text-xl font-semibold mt-8 mb-4">Do you have any of these safety items?</h2>
                    <label for="thirdCategoryButton" id="thirdCategoryButtonLabel"
                        class="flex items-center border duration-150 text-xs border-gray-800 rounded-full py-1 px-3 gap-2 cursor-pointer text-gray-700 hover:text-gray-900 focus-within:text-gray-900">
                        <input type="checkbox" id="thirdCategoryButton">
                        <span class="font-medium duration-150" id="thirdCategoryLabel">Select all</span>
                    </label>
                </div>
                <div class="grid grid-cols-4 gap-4">

                    <label for="Smoke alarm"
                        class="thirdCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Smoke alarm" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Smoke alarm" class="hidden peer">
                        <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M16 1c8.284 0 15 6.716 15 15 0 8.284-6.716 15-15 15-8.284 0-15-6.716-15-15C1 7.716 7.716 1 16 1zm0 2C8.82 3 3 8.82 3 16s5.82 13 13 13 13-5.82 13-13S23.18 3 16 3zm-4.9 14.05l.1-.05a1 1 0 0 1 .474-.095l.126.008c.167.024.314.065.45.124l4.75 2.374V12c0-.552.448-1 1-1s1 .448 1 1v7.412l4.75-2.374a1 1 0 0 1 .617-.157l.133.027c.306.085.54.325.617.632l.025.127a1 1 0 0 1-.096.623l-.055.095-5.85 7.8a1 1 0 0 1-.617.358l-.133.008a1 1 0 0 1-.617-.157l-.112-.083-5.85-7.8a1 1 0 0 1 .02-1.214z">
                            </path>
                        </svg>
                        <span class="block">Smoke alarm</span>
                    </label>


                    <label for="First aid kit"
                        class=" thirdCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="First aid kit" type="checkbox" class="amenityItem" name="amenities[]"
                            value="First aid kit" class="hidden peer">
                        <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M26 3a5 5 0 0 1 4.995 4.783L31 8v16a5 5 0 0 1-4.783 4.995L26 29H6a5 5 0 0 1-4.995-4.783L1 24V8a5 5 0 0 1 4.783-4.995L6 3zm0 2H6a3 3 0 0 0-2.995 2.824L3 8v16a3 3 0 0 0 2.824 2.995L6 27h20a3 3 0 0 0 2.995-2.824L29 24V8a3 3 0 0 0-2.824-2.995zm-7 4v2H8V8zm0 4v2H8v-2zm0 4v2H8v-2zm0 4v2H8v-2z">
                            </path>
                        </svg>
                        <span class="block">First aid kit</span>
                    </label>


                    <label for="Fire extinguisher"
                        class=" thirdCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Fire extinguisher" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Fire extinguisher" class="hidden peer">
                        <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M7 28H5V15c0-4.997 3.356-9.304 8.061-10.603A3 3 0 0 1 17.69 2h.618a3 3 0 0 1 4.63 2.397C27.644 5.696 31 10.003 31 15v13h-2V15c0-4.418-2.953-8.315-7.188-9.5a3.001 3.001 0 0 1-5.624 0C11.953 6.685 9 10.582 9 15v13zm0 2h18v2H7v-2z">
                            </path>
                        </svg>
                        <span class="block">Fire extinguisher</span>
                    </label>


                    <label for="Carbon monoxide alarm"
                        class=" thirdCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Carbon monoxide alarm" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Carbon monoxide alarm" class="hidden peer">
                        <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                            <path
                                d="M25 2a5 5 0 0 1 4.995 4.783L30 7v18a5 5 0 0 1-4.783 4.995L25 30H7a5 5 0 0 1-4.995-4.783L2 25V7a5 5 0 0 1 4.783-4.995L6 2zm0 2H6a3 3 0 0 0-2.995 2.824L3 7v18a3 3 0 0 0 2.824 2.995L6 28h18a3 3 0 0 0 2.995-2.824L29 25V7a3 3 0 0 0-2.824-2.995zm-1 4v2H8V8zm0 4v2H8v-2zm0 4v2H8v-2zm0 4v2H8v-2z">
                            </path>
                        </svg>
                        <span class="block">Carbon monoxide alarm</span>
                    </label>

                    <label for="Sprinkler"
                        class="thirdCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Sprinkler" type="checkbox" class="amenityItem" name="amenities[]" value="Sprinkler"
                            class="hidden peer">
                        <svg fill="#000000" height="64px" width="64px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 870.40 870.40" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <g>
                                        <path
                                            d="M25.119,106.889H8.017c-4.427,0-8.017,3.589-8.017,8.017s3.589,8.017,8.017,8.017h17.102c4.427,0,8.017-3.589,8.017-8.017 S29.546,106.889,25.119,106.889z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M503.983,106.889H323.875v-0.534c0-9.136-7.432-16.568-16.568-16.568H204.693c-9.136,0-16.568,7.432-16.568,16.568v0.534 H59.324c-4.427,0-8.017,3.589-8.017,8.017s3.589,8.017,8.017,8.017h128.802v18.171H8.017c-4.427,0-8.017,3.589-8.017,8.017 s3.589,8.017,8.017,8.017h180.109v0.534c0,9.136,7.432,16.568,16.568,16.568h8.551c0.295,0,0.534,0.239,0.534,0.534v17.102 c0,6.228,3.458,11.659,8.551,14.489v20.25h-0.534c-9.136,0-16.568,7.432-16.568,16.568v34.739H179.04 c-13.851,0-25.119,11.268-25.119,25.119c0,13.851,11.268,25.119,25.119,25.119h34.739v19.104c0,6.709,2.612,13.018,7.357,17.762 l26.847,26.846v14.317h-17.637c-4.427,0-8.017,3.589-8.017,8.017c0,4.427,3.589,8.017,8.017,8.017h51.307 c4.427,0,8.017-3.589,8.017-8.017c0-4.427-3.589-8.017-8.017-8.017h-17.637v-14.317l26.847-26.847 c4.745-4.744,7.357-11.052,7.357-17.762V328.15h34.739c13.851,0,25.119-11.268,25.119-25.119 c0-13.851-11.268-25.119-25.119-25.119h-26.188v-34.739c0-9.136-7.432-16.568-16.568-16.568h-0.534v-20.25 c5.093-2.829,8.551-8.26,8.551-14.489v-17.102c0-0.295,0.239-0.534,0.534-0.534h8.551c9.136,0,16.568-7.432,16.568-16.568v-0.534 h128.802c4.427,0,8.017-3.589,8.017-8.017s-3.589-8.017-8.017-8.017H323.875v-18.171h180.109c4.427,0,8.017-3.589,8.017-8.017 S508.411,106.889,503.983,106.889z M282.188,347.255c0,2.427-0.945,4.708-2.662,6.425L256,377.206l-23.526-23.526 c-1.716-1.716-2.662-3.998-2.662-6.425V328.15h18.171v17.637c0,4.427,3.589,8.017,8.017,8.017c4.427,0,8.017-3.589,8.017-8.017 V328.15h18.171V347.255z M290.205,242.639c0.295,0,0.534,0.239,0.534,0.534v34.739h-9.086c-4.427,0-8.017,3.589-8.017,8.017 s3.589,8.017,8.017,8.017h51.307c5.01,0,9.086,4.076,9.086,9.086c0,5.01-4.076,9.086-9.086,9.086H179.04 c-5.01,0-9.086-4.076-9.086-9.086c0-5.01,4.076-9.086,9.086-9.086h68.409c4.427,0,8.017-3.589,8.017-8.017 s-3.589-8.017-8.017-8.017h-26.188v-34.739c0-0.295,0.239-0.534,0.534-0.534H290.205z M238.363,226.605v-18.171h35.273v18.171 H238.363z M307.841,157.662c0,0.295-0.239,0.534-0.534,0.534h-8.551c-9.136,0-16.568,7.432-16.568,16.568v17.102 c0,0.295-0.239,0.534-0.534,0.534h-51.307c-0.295,0-0.534-0.239-0.534-0.534v-17.102c0-9.136-7.432-16.568-16.568-16.568h-8.551 c-0.295,0-0.534-0.239-0.534-0.534v-51.307c0-0.295,0.239-0.534,0.534-0.534h102.614c0.295,0,0.534,0.239,0.534,0.534V157.662z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M503.983,141.094h-17.099c-4.427,0-8.017,3.589-8.017,8.017s3.589,8.017,8.017,8.017h17.099 c4.427,0,8.017-3.589,8.017-8.017S508.411,141.094,503.983,141.094z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>

                        <span class="block">Sprinkler</span>
                    </label>
                </div>

                <!-- food and beverages -->
                <div class="flex justify-between w-full items-center mb-4">
                    <h2 class="text-xl font-semibold mt-8 mb-4">Food and Beverages</h2>
                    <label for="fourthCategoryButton" id="fourthCategoryButtonLabel"
                        class="flex items-center border duration-150 text-xs border-gray-800 rounded-full py-1 px-3 gap-2 cursor-pointer text-gray-700 hover:text-gray-900 focus-within:text-gray-900">
                        <input type="checkbox" id="fourthCategoryButton">
                        <span class="font-medium duration-150" id="fourthCategoryLabel">Select all</span>
                    </label>
                </div>
                <div class="grid grid-cols-4 gap-4">
                    <label for="Buffet Table"
                        class="fourthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Buffet Table" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Buffet Table" class="hidden peer">
                        <svg width="64px" height="64px" viewBox="-8.4 -8.4 40.80 40.80" id="Layer_1" data-name="Layer 1"
                            xmlns="http://www.w3.org/2000/svg" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <rect class="cls-1" x="3.38" y="7.23" width="17.25" height="3.83"></rect>
                                <line class="cls-1" x1="23.5" y1="7.23" x2="0.5" y2="7.23"></line>
                                <line class="cls-1" x1="3.38" y1="17.77" x2="3.38" y2="11.06"></line>
                                <line class="cls-1" x1="20.63" y1="17.77" x2="20.63" y2="11.06"></line>
                            </g>
                        </svg>

                        <span class="block">Buffet Table</span>
                    </label>

                    <label for="Wine Bar"
                        class="fourthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Wine Bar" type="checkbox" class="amenityItem" name="amenities[]" value="Wine Bar"
                            class="hidden peer">
                        <svg width="64px" height="64px" viewBox="-8.4 -8.4 40.80 40.80" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M12 13V21M12 13C15.3137 13 18 10.3137 18 7V3H6V7C6 10.3137 8.68629 13 12 13ZM8 21H16"
                                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </g>
                        </svg>

                        <span class="block">Wine Bar</span>
                    </label>

                    <label for="Water and Beverage Dispenser"
                        class="fourthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Water and Beverage Dispenser" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Water and Beverage Dispenser" class="hidden peer">
                        <svg width="64px" height="64px" viewBox="-358.4 -358.4 1740.80 1740.80" fill="#000000"
                            class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M224 1003.2c-24.8 0-56-30.4-56-56V112.8c0-24.8 30.4-56 56-56h121.6c1.6-2.4 4-5.6 5.6-8.8 9.6-14.4 19.2-28 29.6-28h261.6c10.4 0 20 13.6 29.6 28.8 1.6 2.4 4 5.6 5.6 8h121.6c14.4 0 28.8 8 38.4 18.4 4.8 4.8 8.8 9.6 12 15.2 1.6 2.4 2.4 5.6 4 8.8 1.6 4.8 1.6 8.8 1.6 13.6v834.4c0 24.8-30.4 56-56 56H224z m-9.6-71.2c0 12.8 10.4 24 24 24h547.2c12.8 0 24-10.4 24-24V920H667.2c-16.8 0-31.2-13.6-31.2-31.2v-3.2c0-6.4-4.8-11.2-11.2-11.2H399.2c-6.4 0-11.2 4.8-11.2 11.2v3.2c0 16.8-13.6 31.2-31.2 31.2H214.4v12zM642.4 832c16.8 0 31.2 13.6 31.2 31.2v3.2c0 6.4 4.8 11.2 11.2 11.2h124.8V128c0-11.2-7.2-20-17.6-23.2H660c-11.2 0-18.4-12.8-25.6-24.8-3.2-4.8-7.2-12.8-9.6-13.6H399.2c-1.6 0.8-6.4 8-8.8 13.6-7.2 12-15.2 24.8-25.6 24.8H232.8c-10.4 2.4-17.6 12-17.6 23.2v748h124.8c6.4 0 11.2-4.8 11.2-11.2v-2.4c0-16.8 13.6-31.2 31.2-31.2h260z"
                                    fill=""></path>
                                <path
                                    d="M265.6 788.8c-16 0-29.6-13.6-29.6-29.6V318.4c0-16 13.6-29.6 29.6-29.6h492.8c16 0 29.6 13.6 29.6 29.6V760c0 16-13.6 29.6-29.6 29.6H265.6z m9.6-47.2c0 4.8 4 8.8 8.8 8.8h455.2c4.8 0 8.8-4 8.8-8.8V336c0-4.8-4-8.8-8.8-8.8H688v20c0 12.8-10.4 22.4-22.4 22.4-12.8 0-22.4-10.4-22.4-22.4v-20H376v20c0 12.8-10.4 22.4-22.4 22.4s-22.4-10.4-22.4-22.4v-20h-46.4c-4.8 0-8.8 3.2-8.8 8l-0.8 406.4zM272 220c-14.4 0-26.4-12-26.4-26.4s12-26.4 26.4-26.4 26.4 12 26.4 26.4-11.2 26.4-26.4 26.4zM336.8 220c-14.4 0-26.4-12-26.4-26.4s12-26.4 26.4-26.4 26.4 12 26.4 26.4-12 26.4-26.4 26.4zM400.8 220c-14.4 0-26.4-12-26.4-26.4s12-26.4 26.4-26.4 26.4 12 26.4 26.4-11.2 26.4-26.4 26.4z"
                                    fill=""></path>
                                <path
                                    d="M327.2 700c-7.2 0-12.8-5.6-12.8-12.8V604.8c0-7.2 5.6-12.8 12.8-12.8s12.8 5.6 12.8 12.8v82.4c0 6.4-5.6 12.8-12.8 12.8z"
                                    fill=""></path>
                                <path
                                    d="M348 754.4c-33.6 0-60.8-27.2-60.8-60.8V584c0-18.4 15.2-33.6 33.6-33.6h82.4c18.4 0 33.6 15.2 33.6 33.6v8.8c2.4-0.8 5.6-0.8 8-0.8 18.4 0 33.6 15.2 33.6 33.6v40.8c0 5.6-1.6 11.2-4.8 16.8-5.6 10.4-16.8 16.8-28.8 16.8-2.4 0-5.6 0-8-0.8-2.4 31.2-28.8 56-60.8 56h-28zM320.8 576c-4 0-8 3.2-8 8v109.6c0 19.2 16 35.2 35.2 35.2h27.2c19.2 0 35.2-16 35.2-35.2V584c0-4-3.2-8-8-8H320.8z m123.2 41.6c-4 0-8 3.2-8 8v40.8c0 4 3.2 8 8 8 4 0 8-3.2 8-8v-40.8c0-4.8-4-8-8-8z"
                                    fill=""></path>
                            </g>
                        </svg>

                        <span class="block">Water and Beverage Dispenser</span>
                    </label>

                    <label for="Plate and Cutlery Set"
                        class="fourthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Plate and Cutlery Set" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Plate and Cutlery Set" class="hidden peer">
                        <svg fill="#000000" height="64px" width="64px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="-179.2 -179.2 870.40 870.40" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <g>
                                        <path
                                            d="M468.885,398.052C497.134,355.933,512,307.127,512,256C512,114.842,397.158,0,256,0S0,114.842,0,256s114.842,256,256,256 c51.124,0,99.93-14.866,142.05-43.115l28.446,28.446c19.526,19.528,51.307,19.529,70.834,0c19.529-19.529,19.529-51.305,0-70.834 L468.885,398.052z M256,478.609c-122.746,0-222.609-99.862-222.609-222.609S133.254,33.391,256,33.391 S478.609,133.254,478.609,256c0,42.209-11.657,82.597-33.862,117.915l-24.329-24.329c16.262-28.455,24.8-60.534,24.8-93.586 c0-104.334-84.883-189.217-189.217-189.217S66.783,151.666,66.783,256S151.666,445.217,256,445.217 c33.05,0,65.129-8.537,93.582-24.799l24.33,24.33C338.593,466.953,298.207,478.609,256,478.609z M319.569,201.517l-61.054-61.054 c-6.519-6.519-17.091-6.519-23.611,0c-6.52,6.519-6.52,17.091,0,23.611l42.332,42.332l-23.611,23.611l-42.333-42.332 c-6.519-6.519-17.091-6.519-23.611,0c-6.52,6.519-6.52,17.091,0,23.611l42.332,42.332l-23.612,23.612l-42.332-42.332 c-6.519-6.519-17.091-6.519-23.611,0s-6.52,17.091,0,23.611l61.054,61.054c28.839,28.84,73.002,31.922,105.072,10.627l21.93,21.93 c-6.305,13.236-6.477,28.682-0.516,42.04c-22.137,11.59-46.721,17.656-71.998,17.656c-85.922,0-155.826-69.904-155.826-155.826 S170.077,100.174,256,100.174S411.826,170.077,411.826,256c0,25.278-6.066,49.862-17.66,72.004 c-13.358-5.96-28.802-5.79-42.04,0.515l-21.93-21.93C351.468,274.554,348.436,230.384,319.569,201.517z M295.959,295.961 c-17.992,17.991-46.067,19.37-65.604,4.55l70.154-70.154C315.317,249.879,313.966,277.954,295.959,295.961z M473.718,473.72 c-6.51,6.509-17.1,6.51-23.612,0c-8.304-8.304-80.087-80.087-88.204-88.204c-6.51-6.51-6.51-17.102,0-23.612 c6.512-6.51,17.1-6.51,23.612,0c7.988,7.988,79.98,79.98,88.204,88.204C480.228,456.618,480.228,467.211,473.718,473.72z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>

                        <span class="block">Plate and Cutlery Set</span>
                    </label>

                    <label for="Microwave Oven"
                        class="fourthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Microwave Oven" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Microwave Oven" class="hidden peer">
                        <svg fill="#000000" width="64px" height="64px" viewBox="-17.5 -17.5 85.00 85.00"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M3 8C1.355469 8 0 9.355469 0 11L0 39C0 40.644531 1.355469 42 3 42L5 42L5 43C5 44.09375 5.90625 45 7 45L10 45C11.09375 45 12 44.09375 12 43L12 42L38 42L38 43C38 44.09375 38.90625 45 40 45L43 45C44.09375 45 45 44.09375 45 43L45 42L47 42C48.644531 42 50 40.644531 50 39L50 11C50 9.355469 48.644531 8 47 8 Z M 3 10L47 10C47.5625 10 48 10.4375 48 11L48 39C48 39.5625 47.5625 40 47 40L39.1875 40C39.054688 39.972656 38.914063 39.972656 38.78125 40L6.1875 40C6.054688 39.972656 5.914063 39.972656 5.78125 40L3 40C2.4375 40 2 39.5625 2 39L2 11C2 10.4375 2.4375 10 3 10 Z M 5 13L5 37L40 37L40 13 Z M 7 15L38 15L38 35L7 35 Z M 44 16C42.894531 16 42 16.894531 42 18C42 19.105469 42.894531 20 44 20C45.105469 20 46 19.105469 46 18C46 16.894531 45.105469 16 44 16 Z M 34.15625 19.9375C33.957031 19.933594 33.761719 19.988281 33.59375 20.09375C33.59375 20.09375 28.964844 22 26.125 22C24.707031 22 23.75 21.59375 22.59375 21.09375C21.4375 20.59375 20.066406 20 18.21875 20C14.523438 20 10.5625 22.09375 10.5625 22.09375C10.0625 22.335938 9.851563 22.9375 10.09375 23.4375C10.335938 23.9375 10.9375 24.148438 11.4375 23.90625C11.4375 23.90625 15.332031 22 18.21875 22C19.664063 22 20.628906 22.40625 21.78125 22.90625C22.933594 23.40625 24.296875 24 26.125 24C29.785156 24 34.40625 21.90625 34.40625 21.90625C34.894531 21.78125 35.214844 21.3125 35.148438 20.8125C35.085938 20.3125 34.660156 19.9375 34.15625 19.9375 Z M 44 23C42.894531 23 42 23.894531 42 25C42 26.105469 42.894531 27 44 27C45.105469 27 46 26.105469 46 25C46 23.894531 45.105469 23 44 23 Z M 34.15625 25.9375C33.957031 25.933594 33.761719 25.988281 33.59375 26.09375C33.59375 26.09375 28.964844 28 26.125 28C24.707031 28 23.75 27.59375 22.59375 27.09375C21.4375 26.59375 20.066406 26 18.21875 26C14.523438 26 10.5625 28.09375 10.5625 28.09375C10.0625 28.335938 9.851563 28.9375 10.09375 29.4375C10.335938 29.9375 10.9375 30.148438 11.4375 29.90625C11.4375 29.90625 15.332031 28 18.21875 28C19.664063 28 20.628906 28.40625 21.78125 28.90625C22.933594 29.40625 24.296875 30 26.125 30C29.785156 30 34.40625 27.90625 34.40625 27.90625C34.894531 27.78125 35.214844 27.3125 35.148438 26.8125C35.085938 26.3125 34.660156 25.9375 34.15625 25.9375 Z M 44 30C42.894531 30 42 30.894531 42 32C42 33.105469 42.894531 34 44 34C45.105469 34 46 33.105469 46 32C46 30.894531 45.105469 30 44 30 Z M 7 42L10 42L10 43L7 43 Z M 40 42L43 42L43 43L40 43Z">
                                </path>
                            </g>
                        </svg>

                        <span class="block">Microwave Oven</span>
                    </label>

                    <label for="Food Pantry"
                        class="fourthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Food Pantry" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Food Pantry" class="hidden peer">
                        <svg fill="#000000" width="64px" height="64px" viewBox="-8.4 -8.4 40.80 40.80"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M22,1H2A1,1,0,0,0,1,2V22a1,1,0,0,0,1,1H22a1,1,0,0,0,1-1V2A1,1,0,0,0,22,1ZM21,17H13V3h8ZM3,3h8V17H3ZM21,21H3V19H21ZM10,9v2a1,1,0,0,1-2,0V9a1,1,0,0,1,2,0Zm4,2V9a1,1,0,0,1,2,0v2a1,1,0,0,1-2,0Z">
                                </path>
                            </g>
                        </svg>

                        <span class="block">Food Pantry</span>
                    </label>

                    <label for="Dish Washer"
                        class="fourthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Dish Washer" type="checkbox" class="amenityItem" name="amenities[]"
                            value="Dish Washer" class="hidden peer">
                        <svg fill="#000000" width="64px" height="64px" viewBox="-43.01 -43.01 208.90 208.90"
                            version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" style="enable-background:new 0 0 100.97 122.88"
                            xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path
                                        d="M82.3,13.63c1.95,0,3.53,1.58,3.53,3.53s-1.58,3.53-3.53,3.53c-1.95,0-3.53-1.58-3.53-3.53S80.35,13.63,82.3,13.63 L82.3,13.63z M66.38,90.12c0.9-2.04,1.44-4.82,1.42-7.88c-0.03-6.26-2.4-11.33-5.28-11.32c-2.88,0.01-5.2,5.1-5.16,11.36 c0.02,3.06,0.59,5.84,1.51,7.88C61.39,94.77,63.89,94.28,66.38,90.12L66.38,90.12z M31.06,103c0.05,0.11,0.1,0.22,0.13,0.34h7.28 c-0.88-2.24-1.6-4.75-2.14-7.45c-0.67-3.37-1.04-7.07-1.06-10.94l0-0.09c-0.03-7.87,1.43-15.03,3.81-20.25 c0.47-1.02,0.97-1.97,1.51-2.85c-0.4-0.34-0.81-0.62-1.23-0.83c-0.57-0.29-1.15-0.46-1.72-0.48l-0.15,0.01v-0.01h-0.01 c-2.46,0.01-4.82,2.5-6.65,6.5c-2.07,4.55-3.34,10.88-3.31,17.9l0,0.07c0.02,3.52,0.36,6.87,0.96,9.91 C29.09,97.92,29.98,100.7,31.06,103L31.06,103z M25.98,103.34c-0.87-2.22-1.59-4.72-2.13-7.42c-0.67-3.38-1.05-7.08-1.07-10.97 l0-0.09c-0.03-7.87,1.43-15.03,3.81-20.25c2.62-5.76,6.44-9.34,10.83-9.36v-0.01h0.01c0.09,0,0.18,0,0.26,0.01 c1.27,0.03,2.49,0.36,3.64,0.95c0.83,0.42,1.63,0.98,2.4,1.67c1.86-1.67,3.94-2.61,6.18-2.62v-0.01h0.01c0.09,0,0.18,0,0.26,0.01 c1.28,0.04,2.52,0.37,3.69,0.98c0.82,0.42,1.6,0.97,2.35,1.64c1.86-1.67,3.94-2.61,6.18-2.62v-0.01h0.01c0.09,0,0.18,0,0.27,0.01 c4.31,0.12,8.08,3.65,10.71,9.31c2.43,5.22,3.96,12.39,4,20.27c0.02,3.78-0.3,7.38-0.89,10.65c-0.52,2.87-1.25,5.52-2.15,7.87h7.96 c0.48,0,0.93-0.2,1.25-0.52c0.32-0.32,0.52-0.76,0.52-1.25V49.04c0-0.48-0.2-0.92-0.52-1.24c-0.32-0.32-0.76-0.52-1.24-0.52H19 c-0.48,0-0.92,0.2-1.24,0.52s-0.52,0.76-0.52,1.24v52.53c0,0.48,0.2,0.92,0.52,1.24c0.32,0.32,0.76,0.52,1.24,0.52H25.98 L25.98,103.34z M43.53,102.96c0.06,0.12,0.11,0.25,0.15,0.38h7.29c-0.92-2.32-1.66-4.94-2.2-7.75c-0.63-3.27-0.98-6.86-1-10.64 l0-0.09c-0.03-7.87,1.43-15.03,3.81-20.25c0.46-1.02,0.97-1.97,1.51-2.85c-0.4-0.34-0.8-0.61-1.21-0.82 c-0.58-0.3-1.16-0.47-1.74-0.49l-0.15,0.01v-0.01h-0.01c-2.46,0.01-4.82,2.5-6.65,6.5c-2.07,4.55-3.34,10.88-3.31,17.9l0,0.07 c0.02,3.51,0.36,6.85,0.96,9.88C41.57,97.9,42.46,100.67,43.53,102.96L43.53,102.96z M55.85,102.57c0.11,0.25,0.18,0.51,0.22,0.77 h13.21c0.03-0.28,0.1-0.56,0.22-0.83c1-2.29,1.81-5.02,2.36-8.06c0.54-2.98,0.83-6.22,0.81-9.59c-0.04-7.05-1.37-13.4-3.49-17.95 c-1.83-3.92-4.15-6.37-6.56-6.46l-0.15,0.01v-0.01h-0.01c-2.46,0.01-4.82,2.5-6.65,6.5c-2.07,4.55-3.34,10.88-3.31,17.9v0.07 c0.02,3.39,0.34,6.64,0.91,9.62C53.99,97.58,54.83,100.3,55.85,102.57L55.85,102.57z M19,42.39h63.32c1.83,0,3.49,0.75,4.69,1.95 c1.2,1.2,1.95,2.87,1.95,4.7v52.53c0,1.82-0.75,3.48-1.95,4.68L87,106.27c-1.2,1.2-2.86,1.95-4.68,1.95H19 c-1.83,0-3.49-0.75-4.7-1.95c-1.2-1.2-1.95-2.86-1.95-4.69V49.04c0-1.83,0.75-3.49,1.95-4.7C15.5,43.14,17.17,42.39,19,42.39 L19,42.39z M16.43,13.63c1.95,0,3.53,1.58,3.53,3.53s-1.58,3.53-3.53,3.53s-3.53-1.58-3.53-3.53S14.48,13.63,16.43,13.63 L16.43,13.63z M31.71,13.27H69.6v7.78H31.71V13.27L31.71,13.27z M4.64,29.67h91.7V6.34c0-0.47-0.19-0.89-0.5-1.2 c-0.31-0.31-0.73-0.5-1.2-0.5H6.34c-0.47,0-0.89,0.19-1.2,0.5c-0.31,0.31-0.5,0.73-0.5,1.2V29.67L4.64,29.67L4.64,29.67z M100.97,116.54c0,1.74-0.71,3.33-1.86,4.48c-1.15,1.15-2.74,1.86-4.48,1.86H6.34c-1.74,0-3.33-0.71-4.48-1.86 C0.71,119.86,0,118.28,0,116.53V6.34c0-1.74,0.71-3.33,1.86-4.48S4.59,0,6.34,0h88.3c1.74,0,3.33,0.71,4.48,1.86 c1.15,1.15,1.86,2.74,1.86,4.48C100.97,44.87,100.97,77.89,100.97,116.54L100.97,116.54z M96.34,34.31H4.64v82.22 c0,0.47,0.19,0.89,0.5,1.2c0.31,0.31,0.73,0.5,1.2,0.5h88.3c0.47,0,0.89-0.19,1.2-0.5c0.31-0.31,0.5-0.73,0.5-1.2V34.31 L96.34,34.31L96.34,34.31z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                        <span class="block">Dish Washer</span>
                    </label>

                </div>

                <!-- Accomodation & Comfort -->
                <div class="flex justify-between w-full items-center mb-4">
                    <h2 class="text-xl font-semibold mt-8 mb-4">Accommodation & Comfort Amenities</h2>
                    <label for="fifthCategoryButton" id="fifthCategoryButtonLabel"
                        class="flex items-center border duration-150 text-xs border-gray-800 rounded-full py-1 px-3 gap-2 cursor-pointer text-gray-700 hover:text-gray-900 focus-within:text-gray-900">
                        <input type="checkbox" id="fifthCategoryButton">
                        <span class="font-medium duration-150" id="fifthCategoryLabel">Select all</span>
                    </label>
                </div>
                <div class="grid grid-cols-4 gap-4">
                    <label for="Bidet"
                        class="fifthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Bidet" type="checkbox" class="amenityItem hidden peer" name="amenities[]"
                            value="Bidet">
                        <svg fill="#000000" height="64px" width="64px" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="-178.85 -178.85 868.70 868.70" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path
                                        d="M415.5,0h-320C82.542,0,72,10.542,72,23.5v304C72,428.682,154.318,511,255.5,511S439,428.682,439,327.5v-304 C439,10.542,428.458,0,415.5,0z M424,327.5c0,92.911-75.589,168.5-168.5,168.5S87,420.411,87,327.5v-304c0-4.687,3.813-8.5,8.5-8.5 h320c4.687,0,8.5,3.813,8.5,8.5V327.5z">
                                    </path>
                                    <path
                                        d="M375.5,104h-56.723c0.847-6.229-0.453-12.736-4.064-18.41l-31.019-48.744c-0.294-0.462-0.637-0.89-1.024-1.277 c-15.4-15.4-40.46-15.402-55.861,0c-7.539,7.538-11.377,17.391-11.536,27.292c-0.035,0.407-0.035,0.822-0.001,1.241 c0.052,3.47,0.556,6.934,1.515,10.295l4.43,29.602H135.5c-12.958,0-23.5,10.542-23.5,23.5v196.398 c0,39.41,16.274,78.017,44.65,105.922c27.058,26.609,62.114,41.178,98.945,41.178c0.778,0,1.558-0.006,2.337-0.02 c37.763-0.631,73.203-15.852,99.79-42.858C384.34,401.083,399,365.349,399,327.5v-200C399,114.542,388.458,104,375.5,104z M271.51,45.64l30.547,48.003c3.149,4.949,2.452,11.302-1.726,15.479c-4.147,4.148-10.5,4.846-15.45,1.696l-48.004-30.548 c-2.499-2.657-4.317-5.786-5.419-9.172l-1.209-8.079c0.122-6.364,2.65-12.33,7.164-16.844 C246.786,36.805,261.92,36.626,271.51,45.64z M273.857,121.582l-6.869,37.095c-1,5.402-5.714,9.323-11.208,9.323 c-5.598,0-10.444-4.175-11.272-9.711l-9.161-61.213L273.857,121.582z M384,327.5c0,33.886-13.128,65.883-36.967,90.098 c-23.812,24.187-55.544,37.818-89.352,38.383c-33.623,0.563-65.774-12.526-90.514-36.855C141.641,394.022,127,359.313,127,323.898 V127.5c0-4.687,3.813-8.5,8.5-8.5h87.961l6.212,41.509C231.592,173.331,242.815,183,255.78,183c12.724,0,23.64-9.081,25.957-21.591 l6.268-33.849c1.188,0.158,2.381,0.244,3.573,0.244c7.059,0,14.045-2.757,19.391-8.103c0.226-0.226,0.426-0.468,0.643-0.7H375.5 c4.687,0,8.5,3.813,8.5,8.5V327.5z">
                                    </path>
                                    <path
                                        d="M254.74,71c1.97,0,3.9-0.8,5.3-2.2c1.4-1.39,2.2-3.32,2.2-5.3s-0.8-3.91-2.2-5.3c-1.4-1.4-3.33-2.2-5.3-2.2 c-1.98,0-3.91,0.8-5.3,2.2c-1.4,1.39-2.2,3.33-2.2,5.3c0,1.97,0.8,3.91,2.2,5.3C250.83,70.2,252.76,71,254.74,71z">
                                    </path>
                                    <path
                                        d="M255.5,192c-12.958,0-23.5,10.542-23.5,23.5s10.542,23.5,23.5,23.5s23.5-10.542,23.5-23.5S268.458,192,255.5,192z M255.5,224c-4.687,0-8.5-3.813-8.5-8.5s3.813-8.5,8.5-8.5s8.5,3.813,8.5,8.5S260.187,224,255.5,224z">
                                    </path>
                                </g>
                            </g>
                        </svg>

                        <span class="block">Bidet</span>
                    </label>
                    <label for="Cleaning Products and Tool"
                        class="fifthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Cleaning Products and Tool" type="checkbox" class="amenityItem hidden peer"
                            name="amenities[]" value="Cleaning Products and Tool">
                        <svg fill="#000000" width="64px" height="64px" viewBox="-43.01 -43.01 208.90 208.90"
                            version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" style="enable-background:new 0 0 93 122.88"
                            xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path
                                        d="M14.6,43.74h15.78c4.87,0,6.1,3.36,6.1,7.71c0,2.02-0.29,4.29-0.58,6.49c-0.47,3.64-0.91,7.06,0.09,8.3 c1.67,2.08,4.08,4.49,6.66,7.07c6.39,6.4,13.77,13.79,14.32,20.41c0.33,4.05,0.4,9.27-0.33,14.09c-0.56,3.72-1.61,7.23-3.38,9.85 c-0.91,1.34-1.97,2.54-3.33,3.46c-1.37,0.92-3.02,1.55-5.09,1.74c-0.03,0-0.07,0-0.1,0v0H18.08c-0.05,0-0.1,0-0.14-0.01 c-2.84-0.16-5.4-0.81-7.55-2.13c-2.21-1.36-3.95-3.41-5.1-6.34c-0.03-0.08-0.05-0.16-0.06-0.24c-2.42-11.87-3.41-23.7-2.25-35.36 c1.16-11.71,4.48-23.25,10.68-34.47C13.84,43.95,14.22,43.75,14.6,43.74L14.6,43.74L14.6,43.74z M4.75,84.84 c18.15,4.31,27.95-9.61,44.29-1.6c-2.41-2.85-5.26-5.71-7.92-8.38c-2.62-2.62-5.07-5.08-6.82-7.24c-1.59-1.97-1.09-5.84-0.56-9.95 c0.27-2.1,0.55-4.27,0.55-6.21c0-3.1-0.79-5.51-3.91-5.51H15.25C9.41,56.72,6.26,67.78,5.15,79C4.95,80.94,4.82,82.89,4.75,84.84 L4.75,84.84z M46.12,6.97L46,20.87c0,0.5-0.34,0.92-0.8,1.04l0,0c-3.35,0.95-6.3,2.23-8.56,4.22c-2.2,1.94-3.78,4.6-4.49,8.36v4.75 c0,0.61-0.49,1.1-1.1,1.1H15.12c-0.95,0.09-1.71-0.13-2.3-0.72c-0.54-0.55-0.83-1.39-0.84-2.57c0-0.04,0-0.08,0-0.11 c0.36-3.9-0.44-6.81-2.28-9.08c-1.89-2.32-4.93-4.05-8.98-5.52c-0.57-0.21-0.86-0.83-0.66-1.4l0-0.01h0c2.19-5.8,5.57-9.5,9.8-11.8 c4.18-2.27,9.16-3.13,14.62-3.28c3.41-0.09,6.84-0.16,10.28-0.17c3.44-0.01,6.87,0.03,10.29,0.16C45.67,5.85,46.14,6.36,46.12,6.97 L46.12,6.97L46.12,6.97z M43.82,20.04l0.1-12.05c-3.06-0.1-6.11-0.13-9.15-0.12c-3.4,0.01-6.81,0.08-10.23,0.17 c-5.14,0.14-9.79,0.94-13.63,3.02c-3.54,1.92-6.41,4.96-8.39,9.63c3.9,1.52,6.88,3.35,8.88,5.8c2.21,2.71,3.17,6.11,2.77,10.6 c0.01,0.55,0.09,0.88,0.22,1.02c0.07,0.07,0.25,0.09,0.52,0.07c0.06-0.01,0.12-0.02,0.18-0.02h14.87v-3.73h0 c0-0.06,0.01-0.13,0.02-0.19c0.8-4.36,2.63-7.45,5.21-9.73C37.56,22.41,40.5,21.04,43.82,20.04L43.82,20.04z M48.36,6.65 l0.09,13.36h6.53c0.92,0.03,1.39-0.74,1.17-2.73V8.9c-0.02-0.73-0.32-1.21-0.88-1.46L48.36,6.65L48.36,6.65z M70.11,10.99 c1.89,0,3.42,1.29,3.42,2.89c0,1.6-1.53,2.89-3.42,2.89c-1.89,0-3.42-1.29-3.42-2.89C66.69,12.28,68.22,10.99,70.11,10.99 L70.11,10.99z M89.58,10.7c1.89,0,3.42,1.29,3.42,2.89c0,1.6-1.53,2.89-3.42,2.89c-1.89,0-3.42-1.29-3.42-2.89 C86.16,11.99,87.69,10.7,89.58,10.7L89.58,10.7z M89.2,21.59c1.89,0,3.42,1.29,3.42,2.89c0,1.6-1.53,2.89-3.42,2.89 s-3.42-1.29-3.42-2.89C85.78,22.88,87.31,21.59,89.2,21.59L89.2,21.59z M79.75,16.48c1.89,0,3.42,1.29,3.42,2.89 c0,1.6-1.53,2.89-3.42,2.89c-1.89,0-3.42-1.29-3.42-2.89C76.33,17.78,77.86,16.48,79.75,16.48L79.75,16.48z M89.58,0 C91.47,0,93,1.29,93,2.89c0,1.6-1.53,2.89-3.42,2.89c-1.89,0-3.42-1.29-3.42-2.89C86.16,1.29,87.69,0,89.58,0L89.58,0z M79.85,5.49 c1.89,0,3.42,1.29,3.42,2.89c0,1.6-1.53,2.89-3.42,2.89c-1.89,0-3.42-1.29-3.42-2.89C76.42,6.79,77.96,5.49,79.85,5.49L79.85,5.49z M36.89,35.65c1.16-4.65,3.94-7.71,8.62-8.9c1.05,7.48,3.33,13.49,6.51,18.38c1.94,2.74-1.21,5.57-3.48,2.68l-7.36-12.04 L36.89,35.65L36.89,35.65z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                        <span class="block">Cleaning Products and Tool</span>
                    </label>
                    <label for="Iron"
                        class="fifthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Iron" type="checkbox" class="amenityItem hidden peer" name="amenities[]"
                            value="Iron">
                        <svg width="64px" height="64px" viewBox="-8.75 -8.75 42.50 42.50" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M19.5 17.0001L18.377 11.5291H8.553C7.505 11.5291 7.114 12.1291 6.653 13.3761L5.5 17.0001H19.5Z"
                                    stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <path d="M18.3771 11.529L17.5281 7H12.1531" stroke="#000000" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>

                        <span class="block">Iron</span>
                    </label>

                    <label for="Garment Rack"
                        class="fifthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Garment Rack" type="checkbox" class="amenityItem hidden peer" name="amenities[]"
                            value="Garment Rack">
                        <svg fill="#000000" height="64px" width="64px" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="-159.6 -159.6 775.20 775.20" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M348,384V128c0-31.75-12.335-55.314-36.662-70.04C292.877,46.786,268.163,40.933,236,40.112V29.835 c4.774-2.771,8-7.928,8-13.835c0-8.822-7.178-16-16-16s-16,7.178-16,16c0,5.907,3.226,11.063,8,13.835v10.277 c-32.163,0.821-56.877,6.674-75.338,17.848C120.335,72.686,108,96.25,108,128v256c-4.418,0-8,3.582-8,8s3.582,8,8,8h24v9.376 c-9.311,3.303-16,12.195-16,22.624c0,13.233,10.767,24,24,24s24-10.767,24-24c0-10.429-6.689-19.321-16-22.624V400h168v9.376 c-9.311,3.303-16,12.195-16,22.624c0,13.233,10.767,24,24,24s24-10.767,24-24c0-10.429-6.689-19.321-16-22.624V400h16 c4.418,0,8-3.582,8-8S352.418,384,348,384z M140,440c-4.411,0-8-3.589-8-8s3.589-8,8-8s8,3.589,8,8S144.411,440,140,440z M324,440 c-4.411,0-8-3.589-8-8s3.589-8,8-8s8,3.589,8,8S328.411,440,324,440z M124,128c0-26.129,9.469-44.562,28.946-56.352 c15.723-9.517,38.267-14.72,67.054-15.525V88h-64c-4.418,0-8,3.582-8,8c0,0.147,0.014,0.292,0.022,0.438 c-0.008,0.146-0.022,0.29-0.022,0.438v15.25c0,4.418,3.582,8,8,8s8-3.582,8-8V104h128v8.125c0,4.418,3.582,8,8,8s8-3.582,8-8v-15.25 c0-0.147-0.014-0.292-0.022-0.438C307.986,96.292,308,96.147,308,96c0-4.418-3.582-8-8-8h-64V56.124 c28.787,0.805,51.331,6.008,67.054,15.525C322.531,83.438,332,101.871,332,128v256H124V128z">
                                </path>
                            </g>
                        </svg>
                        <span class="block">Garment Rack</span>
                    </label>

                    <label for="Sanitary Products"
                        class="fifthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Sanitary Products" type="checkbox" class="amenityItem hidden peer" name="amenities[]"
                            value="Sanitary Products">
                        <svg fill="#000000" class="w-10 h-10 mb-2" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 389.777 389.777" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M314.26,389.777h-85.229c-5.523,0-10-4.477-10-10s4.477-10,10-10h85.229c5.051,0,9.161-3.423,9.161-7.632v-62.676h-85.017 c-5.523,0-10-4.477-10-10s4.477-10,10-10h85.017v-21.915c-15.483,6.972-36.78,6.68-49.246-5.716 c-3.916-3.895-3.934-10.226-0.04-14.142c3.894-3.917,10.226-3.934,14.142-0.04c6.384,6.348,22.114,5.952,31.177-0.785 c0.003-0.002,0.006-0.004,0.009-0.006c1.259-0.937,2.581-1.809,3.957-2.617v-17.482c-15.483,6.975-36.779,6.683-49.244-5.715 c-3.916-3.895-3.933-10.227-0.038-14.142s10.227-3.933,14.142-0.038c6.384,6.35,22.12,5.95,31.18-0.793 c0.014-0.011,0.028-0.021,0.042-0.032c1.247-0.925,2.556-1.787,3.917-2.586v-23.215h-85.017c-5.523,0-10-4.477-10-10s4.477-10,10-10 h81.068l-22.792-32.623c-0.478-0.447-2.365-1.36-5.206-1.36h-62.441c-5.523,0-10-4.477-10-10V68.716c0-8.271,6.729-15,15-15h51.598 c8.271,0,15,6.729,15,15v28.892c5.216,1.598,9.627,4.546,12.366,8.449l28.551,40.865c0.623,0.866,1.109,1.835,1.431,2.877 c0.31,1.005,0.456,2.042,0.442,3.071v33.984c5.31-0.626,10.668-0.445,15.695,0.631c5.401,1.156,8.841,6.471,7.685,11.872 c-1.155,5.4-6.469,8.844-11.872,7.685c-3.628-0.776-7.63-0.742-11.508-0.004v20.602c5.308-0.628,10.668-0.445,15.695,0.632 c5.4,1.156,8.841,6.472,7.685,11.872c-1.156,5.401-6.468,8.842-11.872,7.685c-3.628-0.777-7.629-0.742-11.508-0.004v41.113 c0,0.089-0.001,0.177-0.003,0.266c0.002,0.089,0.003,0.177,0.003,0.266v72.676C343.421,377.381,330.34,389.777,314.26,389.777z M248.989,96.263h31.641V73.716h-41.598v22.546H248.989z M184.308,389.777H52.752c-16.542,0-30-13.458-30-30V123.888 c0-2.129,0.665-4.102,1.799-5.724c0.116-0.248,0.243-0.493,0.381-0.734l31.479-55.005c3.345-5.843,9.232-10.053,16.218-11.855V15 c0-8.271,6.729-15,15-15h61.8c8.271,0,15,6.729,15,15v35.569c6.986,1.803,12.873,6.012,16.218,11.855l31.48,55.005 c0.138,0.242,0.266,0.487,0.381,0.735c1.134,1.621,1.799,3.595,1.799,5.723v235.889C214.308,376.319,200.85,389.777,184.308,389.777 z M42.752,284.512v75.265c0,5.514,4.486,10,10,10h131.556c5.514,0,10-4.486,10-10v-75.265H42.752z M42.752,264.512h151.556V133.888 H42.752V264.512z M50.003,113.888h137.054L163.29,72.359c-0.767-1.341-3.355-2.766-6.639-2.766H80.409 c-3.284,0-5.872,1.425-6.639,2.767L50.003,113.888z M92.63,49.593h51.8V20h-51.8V49.593z M108.05,182.586 c0,7.366-6.49,13.338-14.495,13.338s-14.495-5.972-14.495-13.338c0-7.367,6.49-13.338,14.495-13.338S108.05,175.219,108.05,182.586z M143.505,169.248c-8.005,0-14.495,5.972-14.495,13.338c0,7.366,6.49,13.338,14.495,13.338S158,189.952,158,182.586 C158,175.219,151.511,169.248,143.505,169.248z M118.415,208.574c-8.005,0-14.495,5.972-14.495,13.338 c0,7.367,6.49,13.338,14.495,13.338c8.005,0,14.495-5.972,14.495-13.338C132.909,214.546,126.42,208.574,118.415,208.574z">
                                </path>
                            </g>
                        </svg>

                        <span class="block">Sanitary Products</span>
                    </label>

                    <label for="Hair Dryer"
                        class="fifthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Hair Dryer" type="checkbox" class="amenityItem hidden peer" name="amenities[]"
                            value="Hair Dryer">
                        <svg height="64px" width="64px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-179.2 -179.2 870.40 870.40"
                            xml:space="preserve" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path class="st0"
                                        d="M459.949,39.433C434.165,14.134,399.516,0,363.468,0c-0.874,0-1.74,0.007-2.614,0.027l-0.6,0.014 L105.216,28.18l-94.44-16.304V276.85l94.413-15.792l138.991,15.096v170.63c0,8.968,1.822,17.58,5.132,25.388 c4.954,11.724,13.205,21.647,23.613,28.677c10.387,7.03,23.005,11.152,36.471,11.152c8.968,0,17.58-1.829,25.388-5.132 c11.718-4.961,21.648-13.212,28.677-23.613c7.03-10.394,11.151-23.012,11.151-36.471V288.315 c31.981-2.593,62.227-16.256,85.336-38.935c26.398-25.913,41.275-61.34,41.275-98.33v-13.288 C501.224,100.774,486.346,65.339,459.949,39.433z M95.143,236.01l-57.996,9.691V43.186l57.996,10.019V236.01z M348.243,446.784 c0,5.398-1.092,10.476-3.044,15.117c-2.942,6.954-7.89,12.912-14.093,17.102c-6.218,4.19-13.623,6.627-21.71,6.627 c-5.405,0-10.483-1.085-15.124-3.044c-6.947-2.942-12.912-7.889-17.102-14.093c-4.19-6.217-6.62-13.615-6.627-21.709V279.02 l77.699,8.449V446.784z M386.945,259.904c-7.664,1.658-15.526,2.532-23.477,2.532c-0.512,0-1.044,0-1.57-0.014l-240.385-26.111 v-183.4l240.406-26.527c0.519-0.014,1.038-0.014,1.549-0.014c7.951,0,15.813,0.874,23.477,2.532V259.904z M474.854,151.05 c0,29.913-12.025,58.563-33.373,79.507c-8.36,8.197-17.888,14.926-28.172,20.072V38.177c10.285,5.146,19.812,11.868,28.172,20.078 c21.348,20.944,33.373,49.595,33.373,79.507V151.05z">
                                    </path>
                                    <path class="st0"
                                        d="M203.266,305.54v36.335c0,6.469,5.248,11.71,11.718,11.71h23.436v-59.763h-23.436 C208.515,293.822,203.266,299.071,203.266,305.54z">
                                    </path>
                                </g>
                            </g>
                        </svg>

                        <span class="block">Hair Dryer</span>
                    </label>

                    <label for="Grooming Kit"
                        class="fifthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Grooming Kit" type="checkbox" class="amenityItem hidden peer" name="amenities[]"
                            value="Grooming Kit">
                        <svg fill="#000000" height="64px" width="64px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="-179.2 -179.2 870.40 870.40" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <g>
                                        <path
                                            d="M509.943,416.304c-2.261-9.763-4.333-19.559-6.159-29.117c-0.824-4.316-4.991-7.142-9.306-6.321 c-4.316,0.824-7.145,4.991-6.321,9.307c1.865,9.759,3.979,19.759,6.286,29.72c1.095,4.726,1.649,9.663,1.649,14.676 c0,16.871-6.505,32.707-16.975,41.327c-0.065,0.054-0.129,0.108-0.192,0.162c-0.067,0.051-0.134,0.103-0.199,0.155 c-5.034,4.02-10.724,6.144-16.454,6.144c-5.73,0-11.421-2.124-16.455-6.144c-0.064-0.052-0.129-0.102-0.195-0.152 c-0.065-0.056-0.129-0.111-0.195-0.165c-10.471-8.621-16.975-24.456-16.975-41.327c0-5.011,0.555-9.948,1.649-14.674 c10.837-46.801,16.898-92.29,18.012-135.203c0.055-2.145-0.757-4.22-2.255-5.758c-1.498-1.536-3.552-2.403-5.698-2.403H333.949 v-21.591h95.879c4.393,0,7.955-3.56,7.955-7.955c0-4.394-3.562-7.954-7.955-7.954h-95.879v-22.813h95.879 c4.393,0,7.955-3.56,7.955-7.955c0-4.394-3.562-7.954-7.955-7.954h-95.879v-22.813h95.879c4.393,0,7.955-3.56,7.955-7.955 c0-4.394-3.562-7.954-7.955-7.954h-95.879v-22.813h95.879c4.393,0,7.955-3.56,7.955-7.955c0-4.394-3.562-7.954-7.955-7.954 h-95.879v-22.811h95.879c4.393,0,7.955-3.56,7.955-7.955c0-4.394-3.562-7.955-7.955-7.955h-95.879V61.334h43.978 c4.393,0,7.955-3.56,7.955-7.954c0-4.394-3.562-7.955-7.955-7.955h-43.978V29.644h105.224c20.427,0,37.046,16.619,37.046,37.046 v203.188c0,30.218,2.488,61.811,7.394,93.901c0.664,4.342,4.723,7.321,9.066,6.661c4.342-0.664,7.325-4.723,6.661-9.066 c-4.785-31.297-7.211-62.08-7.211-91.496V66.69c0-29.199-23.755-52.955-52.955-52.955h-113.18c-4.393,0-7.955,3.561-7.955,7.954 v262.796c0,4.394,3.562,7.955,7.955,7.955h105.943c-1.602,39.443-7.425,81.068-17.336,123.865 c-1.367,5.902-2.06,12.046-2.06,18.264c0,21.015,7.889,40.372,21.2,52.26c0.889,1.336,2.17,2.388,3.68,2.991 c7.522,5.532,16.074,8.446,24.849,8.446c8.773,0,17.326-2.913,24.848-8.446c1.51-0.602,2.792-1.655,3.681-2.991 c13.31-11.888,21.2-31.246,21.2-52.26C512.002,428.351,511.309,422.207,509.943,416.304z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M429.827,45.425h-25.844c-4.393,0-7.955,3.56-7.955,7.955c0,4.394,3.562,7.954,7.955,7.954h25.844 c4.393,0,7.954-3.56,7.954-7.954C437.782,48.985,434.22,45.425,429.827,45.425z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M274.087,379.241c-25.9,0-46.971,21.071-46.971,46.971c0.001,25.9,21.071,46.97,46.971,46.97 c25.899,0,46.97-21.07,46.97-46.97S299.986,379.241,274.087,379.241z M274.087,457.272c-17.128,0-31.062-13.934-31.062-31.061 c0.001-17.129,13.934-31.062,31.062-31.062c17.127,0,31.061,13.934,31.061,31.062 C305.148,443.338,291.214,457.272,274.087,457.272z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M350.492,423.486c-1.334-38.304-32.302-70.589-70.499-73.504c-6.734-0.511-13.48-0.145-20.075,1.093l-9.478-1.548 c-12.289-2.008-23.791-7.924-32.582-16.724l-6.455-20.854L258.562,53.45c2.836-15.547-2.772-31.692-14.637-42.133 c-2.025-1.782-4.812-2.418-7.411-1.684c-2.596,0.731-4.644,2.727-5.442,5.304l-55.8,180.278L119.472,14.939 c-0.798-2.577-2.847-4.574-5.442-5.304c-2.596-0.733-5.386-0.098-7.411,1.684C94.754,21.76,89.145,37.904,91.981,53.451 l17.419,95.485c0.789,4.322,4.932,7.185,9.254,6.398c4.322-0.788,7.186-4.931,6.398-9.253l-17.419-95.485 c-0.963-5.276-0.426-10.66,1.406-15.563l58.634,189.435c0,0,0,0,0,0.001l27.956,90.323c0,0.001,0.001,0.002,0.001,0.003 l7.592,24.528c0.357,1.155,0.974,2.213,1.802,3.095c11.319,12.044,26.537,20.145,42.85,22.811l10.565,1.725 c1.04,0.213,2.133,0.222,3.22-0.006c5.606-1.171,11.366-1.543,17.122-1.102c29.734,2.269,54.771,28.374,55.811,58.193 c0.579,16.602-5.44,32.308-16.951,44.227c-11.516,11.923-26.984,18.492-43.557,18.492c-27.513,0-51.595-18.565-58.564-45.145 c-0.057-0.218-0.124-0.434-0.198-0.645l-27.621-117.543c-0.605-2.573-2.448-4.677-4.918-5.616l-4.678-1.778 c-0.003-0.001-0.006-0.003-0.01-0.004l-21.015-7.985l-2.67-1.014l-24.603-134.871c-0.789-4.322-4.933-7.188-9.254-6.398 c-4.322,0.788-7.186,4.931-6.398,9.253l24.982,136.941l-6.455,20.852c-8.79,8.8-20.292,14.716-32.582,16.724l-9.479,1.548 c-6.587-1.236-13.363-1.605-20.076-1.094c-38.196,2.915-69.163,35.2-70.5,73.502c-0.731,20.954,6.872,40.782,21.406,55.833 c14.541,15.056,34.073,23.349,55.001,23.349c34.379,0,64.52-22.962,73.672-55.975c0.143-0.359,0.261-0.733,0.351-1.12 l24.793-105.503l24.793,105.503c0.09,0.385,0.209,0.759,0.351,1.119c9.152,33.014,39.292,55.977,73.671,55.977 c20.927,0,40.46-8.292,55.001-23.349C343.62,464.268,351.222,444.439,350.492,423.486z M201.229,279.077l-17.63-56.961 l57.907-187.082c1.833,4.902,2.368,10.285,1.406,15.562L201.229,279.077z M135.219,440.968c-0.074,0.21-0.141,0.425-0.198,0.645 c-6.969,26.58-31.051,45.143-58.564,45.143c-16.572,0-32.041-6.566-43.557-18.492c-11.509-11.918-17.529-27.624-16.949-44.226 c1.04-29.819,26.077-55.924,55.811-58.193c1.559-0.119,3.138-0.179,4.694-0.179c4.169,0,8.351,0.431,12.428,1.281 c1.084,0.226,2.171,0.218,3.205,0.01l10.581-1.728c16.313-2.666,31.531-10.766,42.85-22.811c0.828-0.88,1.445-1.94,1.802-3.095 l4.977-16.081l4.199,1.595l5.518,2.097L135.219,440.968z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M76.456,379.241c-25.9,0-46.971,21.071-46.971,46.971c0,25.9,21.071,46.97,46.971,46.97c25.9,0,46.971-21.07,46.971-46.97 S102.356,379.241,76.456,379.241z M76.456,457.272c-17.128,0-31.062-13.934-31.062-31.061c0-17.129,13.934-31.062,31.062-31.062 c17.128,0,31.062,13.934,31.062,31.062C107.518,443.338,93.584,457.272,76.456,457.272z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>

                        <span class="block">Grooming Kit</span>
                    </label>

                    <label for="Fresh Towels"
                        class="fifthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Fresh Towels" type="checkbox" class="amenityItem hidden peer" name="amenities[]"
                            value="Fresh Towels">
                        <svg fill="#000000" height="32px" width="32px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="-168 -168 816.00 816.00" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <g>
                                        <path
                                            d="M472,0h-40c-13.232,0-24,10.768-24,24h-16c0-13.232-10.768-24-24-24h-48H160h-48C98.768,0,88,10.768,88,24H72 C72,10.768,61.232,0,48,0H8C3.584,0,0,3.584,0,8v48v32c0,4.416,3.584,8,8,8h40c13.232,0,24-10.768,24-24h16v256v32v40 c0,13.232,10.768,24,24,24h256c13.232,0,24-10.768,24-24v-40v-32V72h16c0,13.232,10.768,24,24,24h40c4.424,0,8-3.584,8-8V56V8 C480,3.584,476.424,0,472,0z M56,72c0,4.408-3.592,8-8,8H16V64h40V72z M56,32v16H16V16h32c4.408,0,8,3.592,8,8V32z M88,56H72V40 h16V56z M168,16h144v104H168V16z M168,136h144v40H168V136z M168,192h144v8c0,4.408-3.584,8-8,8H176c-4.408,0-8-3.592-8-8V192z M376,400c0,4.408-3.584,8-8,8H112c-4.408,0-8-3.592-8-8v-32h272V400z M376,352H104v-16h272V352z M376,32v32v256H104V64V32v-8 c0-4.408,3.592-8,8-8h40v112v56v16c0,13.232,10.768,24,24,24h128c13.232,0,24-10.768,24-24v-16v-56V16h40c4.416,0,8,3.592,8,8V32z M408,56h-16V40h16V56z M464,80h-32c-4.416,0-8-3.592-8-8v-8h40V80z M464,48h-40V32v-8c0-4.408,3.584-8,8-8h32V48z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M184,464H32c-4.416,0-8,3.584-8,8c0,4.416,3.584,8,8,8h152c4.416,0,8-3.584,8-8C192,467.584,188.416,464,184,464z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M448,464H288c-4.424,0-8,3.584-8,8c0,4.416,3.576,8,8,8h160c4.424,0,8-3.584,8-8C456,467.584,452.424,464,448,464z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M248,464h-16c-4.416,0-8,3.584-8,8c0,4.416,3.584,8,8,8h16c4.424,0,8-3.584,8-8C256,467.584,252.424,464,248,464z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>

                        <span class="block">Fresh Towels</span>
                    </label>
                    <label for="Dressing and Vanity Area"
                        class="fifthCategory p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black peer-checked:bg-gray-100 peer-checked:border-black transition">
                        <input id="Dressing and Vanity Area" type="checkbox" class="amenityItem hidden peer"
                            name="amenities[]" value="Dressing and Vanity Area">

                        <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-153.65 -153.65 746.29 746.29"
                            xml:space="preserve" width="64px" height="64px">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path
                                        d="M307.039,0H131.946v228.883h175.093V0z M300.039,221.883H138.946V7h161.093V221.883z">
                                    </path>
                                    <path
                                        d="M287.587,17.532H151.398v193.819h136.188V17.532z M158.398,82.379l57.847-57.847h33.804l-91.65,91.65V82.379z M206.347,24.532L158.398,72.48V24.532H206.347z M158.398,126.081L259.947,24.532h20.64v125.234l-54.584,54.585h-67.604V126.081z M235.901,204.352l44.686-44.686v44.686H235.901z">
                                    </path>
                                    <path
                                        d="M108.155,30.532c8.418,0,15.267-6.848,15.267-15.266S116.573,0,108.155,0S92.89,6.849,92.89,15.267 S99.737,30.532,108.155,30.532z M108.155,7c4.559,0,8.267,3.708,8.267,8.267c0,4.558-3.708,8.266-8.267,8.266 c-4.558,0-8.266-3.708-8.266-8.266C99.89,10.708,103.598,7,108.155,7z">
                                    </path>
                                    <path
                                        d="M108.155,80.12c8.418,0,15.267-6.849,15.267-15.267s-6.849-15.266-15.267-15.266S92.89,56.436,92.89,64.854 S99.737,80.12,108.155,80.12z M108.155,56.588c4.559,0,8.267,3.708,8.267,8.266c0,4.559-3.708,8.267-8.267,8.267 c-4.558,0-8.266-3.708-8.266-8.267C99.89,60.296,103.598,56.588,108.155,56.588z">
                                    </path>
                                    <path
                                        d="M108.155,179.295c8.418,0,15.267-6.848,15.267-15.266s-6.849-15.266-15.267-15.266s-15.266,6.848-15.266,15.266 S99.737,179.295,108.155,179.295z M108.155,155.764c4.559,0,8.267,3.708,8.267,8.266s-3.708,8.266-8.267,8.266 c-4.558,0-8.266-3.708-8.266-8.266S103.598,155.764,108.155,155.764z">
                                    </path>
                                    <path
                                        d="M108.155,228.883c8.418,0,15.267-6.848,15.267-15.266s-6.849-15.266-15.267-15.266s-15.266,6.848-15.266,15.266 S99.737,228.883,108.155,228.883z M108.155,205.352c4.559,0,8.267,3.708,8.267,8.266s-3.708,8.266-8.267,8.266 c-4.558,0-8.266-3.708-8.266-8.266S103.598,205.352,108.155,205.352z">
                                    </path>
                                    <path
                                        d="M108.155,129.708c8.418,0,15.267-6.849,15.267-15.267s-6.849-15.266-15.267-15.266s-15.266,6.848-15.266,15.266 S99.737,129.708,108.155,129.708z M108.155,106.176c4.559,0,8.267,3.708,8.267,8.266c0,4.559-3.708,8.267-8.267,8.267 c-4.558,0-8.266-3.708-8.266-8.267C99.89,109.884,103.598,106.176,108.155,106.176z">
                                    </path>
                                    <path
                                        d="M330.83,30.532c8.418,0,15.267-6.848,15.267-15.266S339.248,0,330.83,0s-15.266,6.849-15.266,15.267 S322.412,30.532,330.83,30.532z M330.83,7c4.559,0,8.267,3.708,8.267,8.267c0,4.558-3.708,8.266-8.267,8.266 c-4.558,0-8.266-3.708-8.266-8.266C322.564,10.708,326.272,7,330.83,7z">
                                    </path>
                                    <path
                                        d="M330.83,80.12c8.418,0,15.267-6.849,15.267-15.267s-6.849-15.266-15.267-15.266s-15.266,6.848-15.266,15.266 S322.412,80.12,330.83,80.12z M330.83,56.588c4.559,0,8.267,3.708,8.267,8.266c0,4.559-3.708,8.267-8.267,8.267 c-4.558,0-8.266-3.708-8.266-8.267C322.564,60.296,326.272,56.588,330.83,56.588z">
                                    </path>
                                    <path
                                        d="M330.83,179.295c8.418,0,15.267-6.848,15.267-15.266s-6.849-15.266-15.267-15.266s-15.266,6.848-15.266,15.266 S322.412,179.295,330.83,179.295z M330.83,155.764c4.559,0,8.267,3.708,8.267,8.266s-3.708,8.266-8.267,8.266 c-4.558,0-8.266-3.708-8.266-8.266S326.272,155.764,330.83,155.764z">
                                    </path>
                                    <path
                                        d="M330.83,228.883c8.418,0,15.267-6.848,15.267-15.266s-6.849-15.266-15.267-15.266s-15.266,6.848-15.266,15.266 S322.412,228.883,330.83,228.883z M330.83,205.352c4.559,0,8.267,3.708,8.267,8.266s-3.708,8.266-8.267,8.266 c-4.558,0-8.266-3.708-8.266-8.266S326.272,205.352,330.83,205.352z">
                                    </path>
                                    <path
                                        d="M330.83,129.708c8.418,0,15.267-6.849,15.267-15.267s-6.849-15.266-15.267-15.266s-15.266,6.848-15.266,15.266 S322.412,129.708,330.83,129.708z M330.83,106.176c4.559,0,8.267,3.708,8.267,8.266c0,4.559-3.708,8.267-8.267,8.267 c-4.558,0-8.266-3.708-8.266-8.267C322.564,109.884,326.272,106.176,330.83,106.176z">
                                    </path>
                                    <rect x="127.315" y="259.324" width="18.489" height="7"></rect>
                                    <rect x="293.181" y="259.324" width="18.489" height="7"></rect>
                                    <path
                                        d="M50.132,243.639v195.351h18.12V319.998h302.485v118.991h18.12V243.639H50.132z M381.857,250.639v41.84H222.993v-41.844 h151.244v0.004H381.857z M57.132,292.479v-41.84l158.861-0.004v41.844H57.132z M57.132,431.989V299.479h4.12v132.511H57.132z M68.252,312.998v-13.52h302.485v13.52H68.252z M377.737,431.989V299.479h4.12v132.511H377.737z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                        <span class="block">Dressing and Vanity Area</span>
                    </label>
                </div>
            </div>

            <div id="step4" class="step">
                <div class="mb-2">
                    <h1 class="text-3xl font-bold ">Where's your place located?</h1>
                    <p class="text-gray-600 ">Your address is only shared with guests after they've made a
                        reservation.
                    </p>
                </div>
                <?php require_once './openStreetMap/userOpenStreetMap.html' ?>
                <input type="text" id="venue-location" name="venue-location" class="hidden">
                <input type="text" id="venueCoordinates" name="venueCoordinates" class="hidden">
            </div>

            <div id="step5" class="step">
                <h1 class="text-4xl font-bold mb-4">Add photos of your venue</h1>
                <p class="text-xl text-gray-600 mb-8">Photos help guests imagine staying in your place. You can start
                    with one and add more after you publish.</p>

                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                    <div class="space-y-4">
                        <!-- Input File -->
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <label for="file-upload" class="cursor-pointer">
                            <span class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">Upload from your
                                device</span>
                            <input id="file-upload" class="hidden" type="file" name="venue_images[]" multiple
                                accept=".jpg,.jpeg,.png" required>
                        </label>
                        <p class="text-gray-500">Upload at least 5 photos</p>
                        <div id="image-count" class="text-gray-600 mt-2 text-xl font-semibold">Uploaded images: 0</div>

                        <!-- Image Previews -->
                        <div id="image-preview-container" class="mt-6 grid grid-cols-3 gap-4">
                            <!-- Preview images will appear here -->
                        </div>
                        <input type="hidden" name="imageThumbnail" id="imageThumbnail">
                    </div>
                </div>


            </div>

            <div id="step6" class="step">
                <h1 class="text-4xl font-bold mb-4">Create your description</h1>
                <p class="text-gray-600 mb-8">Share what makes your place special.</p>

                <div class="space-y-6">
                    <div>
                        <textarea id="venue-description" name="venue-description"
                            class="w-full p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                            rows="12"
                            placeholder="Tell guests what you love about your venue and what makes it unique..."></textarea>
                        <p class="text-gray-500 text-sm mt-2">Minimum 100 characters</p>
                    </div>
                </div>
            </div>

            <div id="step7" class="step">
                <h1 class="text-4xl font-bold mb-4">Create your title</h1>
                <p class="text-gray-600 mb-8">Catch guests' attention with a listing title that highlights what makes
                    your
                    place special.</p>

                <div class="space-y-6">
                    <div>
                        <input type="text" name="venue-title" id="venue-title"
                            class="w-full p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                            placeholder="Enter title">
                        <p class="text-gray-500 text-sm mt-2">50 characters maximum</p>
                    </div>
                </div>
                <h1 class="text-4xl font-bold mb-4 mt-12">Number of Guest</h1>
                <p class="text-gray-600 mb-8">How many guest can fit in your venue?</p>

                <div class="flex items-center gap-4">
                    <div>
                        <label for="venue-min-guest">Minimum number of guest</label>
                        <input type="number" name="min-attendees" id="min-attendees"
                            class="w-full p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                            placeholder="Number of guest">
                    </div>
                    <div>
                        <label for="venue-min-guest">Maximum number of guest</label>
                        <input type="number" name="max-attendees" id="max-attendees"
                            class="w-full p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                            placeholder="Number of guest">
                    </div>
                </div>
            </div>

            <div id="step8" class="step">
                <h2 class="text-2xl font-semibold mb-2">Step 3</h2>
                <h1 class="text-4xl font-bold mb-4">Finish up and publish</h1>
                <p class="text-xl text-gray-600 mb-8">Finally, you'll choose booking settings, set up pricing, and
                    publish
                    your listing.</p>
            </div>

            <div id="step9" class="step">
                <h1 class="text-4xl font-bold mb-4">Set your house rules</h1>
                <p class="text-gray-600 mb-8">Let guests know what they can expect when booking your venue.</p>

                <div class="space-y-6">
                    <div class="space-y-4">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="fixedRules[]" value="No smoking"
                                class="form-checkbox h-5 w-5 text-black">
                            <span>No smoking</span>
                        </label>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="fixedRules[]" value="No parties or events"
                                class="form-checkbox h-5 w-5 text-black">
                            <span>No parties or events</span>
                        </label>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="fixedRules[]" value="No pets"
                                class="form-checkbox h-5 w-5 text-black">
                            <span>No pets</span>
                        </label>
                    </div>


                    <div>
                        <h3 class="font-semibold mb-2">Additional rules (optional)</h3>
                        <textarea class="w-full p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                            rows="4" placeholder="Add any other rules or guidelines..."
                            name="additionalRules"></textarea>
                    </div>
                </div>
            </div>

            <div id="step10" class="step ">
                <h1 class="text-3xl font-bold mb-2">Now, set your price</h1>
                <p class="text-gray-600 mb-6">You can change it anytime.</p>

                <div class="text-center mb-8">
                    <div class="text-center mb-8 flex flex-col gap-10">
                        <div class="flex  items-center w-full gap-4">
                            <div class="w-full">
                                <input type="number" name="price" id="price"
                                    class="w-full p-4 border rounded-lg text-center font-bold focus:outline-none focus:ring-2 focus:ring-black"
                                    placeholder="₱0">
                            </div>
                            <div class="w-full">
                                <select name="pricing-type" id="pricing-type"
                                    class="w-full p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
                                    <option value="">Select Pricing option</option>
                                    <option value="fixed">Per hour rate</option>
                                    <option value="per_head">Per head count * hours</option>
                                </select>
                            </div>
                        </div>
                        <!-- Add preferred check-in and check-out times -->
                        <div class="flex items-center w-full gap-4">
                            <div class="w-full flex flex-col items-start">
                                <h2 class="text-lg font-semibold">Minimun Booking Hours</h2>
                                <input type="number" name="min-time" id="min-time" min="1"
                                    class="w-full p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                                    placeholder="Minimun Booking time limit">
                            </div>
                            <div class="w-full flex flex-col items-start">
                                <h2 class="text-lg font-semibold">Maximum Booking Hours</h2>
                                <input type="number" name="max-time" id="max-time" min="1"
                                    class="w-full p-4 border  rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                                    placeholder="Maximum Booking time limit">
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div id="step11" class="step">
                <h1 class="text-3xl font-bold mb-4">Additional fees</h1>
                <p class="text-gray-600 mb-8">Set optional fees for your venue.</p>

                <div class="space-y-8">
                    <!-- Entrance Fee Section -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h2 class="text-xl font-semibold">Entrance fee</h2>
                                <p class="text-gray-500 text-sm">Add if you charge per person for entry</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="entrance-fee-toggle" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gray-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-slate-50 after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black">
                                </div>
                            </label>
                        </div>
                        <div id="entrance-fee-input" class="hidden">
                            <div class="flex items-center space-x-4">
                                <div class="relative flex-1">
                                    <span class="absolute left-3 top-2 text-gray-500">₱</span>
                                    <input type="number" name="entrance-fee"
                                        class="w-full pl-8 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                                        placeholder="0">
                                </div>
                                <span class="text-gray-600">per person</span>
                            </div>
                        </div>
                    </div>

                    <!-- Cleaning Fee Section -->

                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h2 class="text-xl font-semibold">Cleaning fee</h2>
                                <p class="text-gray-500 text-sm">Add if you charge for cleaning</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="cleaning-fee-toggle" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gray-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-slate-50 after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black">
                                </div>
                            </label>
                        </div>
                        <div id="cleaning-fee-input" class="hidden">
                            <div class="flex items-center space-x-4">
                                <div class="relative flex-1">
                                    <span class="absolute left-3 top-2 text-gray-500">₱</span>
                                    <input type="number" name="cleaning-fee"
                                        class="w-full pl-8 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                                        placeholder="0">
                                </div>
                                <span class="text-gray-600">one-time fee</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="step12" class="step">
                <h1 class="text-3xl font-bold mb-4">Review your listing</h1>
                <p class="text-gray-600 mb-6">Here's what we'll show to guests. Make sure everything looks good.</p>

                <div class="bg-gray-100 rounded-lg p-4 mb-8">
                    <div id="image-preview-container" class="mt-4">
                        <!-- Images will be appended here -->
                    </div>
                    <div class="mt-4">
                        <h2 class="text-xl font-semibold" id="venue-title-preview"></h2>
                        <p class="text-gray-600" id="venue-price-preview">
                        </p>
                    </div>
                </div>

                <h2 class="text-2xl font-semibold mb-4">What's next?</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold">Confirm a few details and publish</h3>
                            <p class="text-gray-600">We'll let you know if your venue is successfully posted</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-6 h-6 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <div>
                            <h3 class="font-semibold">Set up your calendar</h3>
                            <p class="text-gray-600">Choose which dates your listing is available. It will be visible
                                after
                                you we publish you posted venue.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-6 h-6 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                            </path>
                        </svg>
                        <div>
                            <h3 class="font-semibold">Adjust your settings</h3>
                            <p class="text-gray-600">Set house rules, select a cancellation policy, choose how guests
                                book,
                                and more.</p>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" id="VenuePostButton"></button>
        </form>

        <div class="fixed bottom-0 left-0 right-0 bg-slate-50 border-t">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <button onclick="prevStep()"
                    class="text-black border-2 rounded-lg px-6 py-3 font-semibold hover:underline">Back</button>
                <div class="progress-bar w-1/3">
                    <div id="progress" class="progress" style="width: 7.14%;"></div>
                </div>
                <button onclick="nextStep()"
                    class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800">Next</button>
            </div>
        </div>
    </div>


    <script src="./vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
    <script src="./js/user.jquery.js"></script>
    <script>
        const urlParams = window.location.href;
        if (urlParams.includes('list-your-venue.php')) {
            document.getElementById('closeMap').style.display = 'none';
        }
    </script>


    <script>
        let currentStep = 1;
        const totalSteps = 12;

        // Replace the existing defaultDescription with this new version
        const defaultDescription = `A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.`;

        function nextStep() {
            if (currentStep < totalSteps) {

                if (currentStep === 2) {
                    const selectedPlaceType = Array.from(document.querySelectorAll('.placeType')).find(
                        (placeType) => placeType.checked
                    );

                    if (!selectedPlaceType) {
                        showModal('Please select a venue type.', undefined, 'black_ico.png');
                        return;
                    }
                }

                if (currentStep === 3) {
                    const selectedAmenities = Array.from(document.querySelectorAll('.amenityItem')).filter(
                        (amenity) => amenity.checked
                    );

                    if (selectedAmenities.length < 1) {
                        showModal('Please select at least one amenity.', undefined, 'black_ico.png');
                        return;
                    }
                }

                if (currentStep === 4) {
                    const venueLocation = document.getElementById('venue-location').value;

                    if (!venueLocation) {
                        showModal('Please select a location for your venue.', undefined, 'black_ico.png');
                        return;
                    }
                }

                if (currentStep === 5) {
                    const fileInput = document.getElementById('file-upload');
                    const imagesCount = fileInput.files.length;

                    if (imagesCount < 5) {
                        showModal('Please upload at least 5 images.', undefined, 'black_ico.png');
                        return;
                    }

                    if (mainImageIndex === null || mainImageIndex === -1) {
                        showModal('Please set one image as your Main Image.', undefined, 'black_ico.png');
                        return;
                    }
                }

                if (currentStep === 6) {
                    const descriptionTextCount = document.getElementById('venue-description').value.length;
                    if (descriptionTextCount < 100) {
                        showModal('Please enter a description with at least 100 characters.', undefined, 'black_ico.png');
                        return;
                    }
                }

                if (currentStep === 7) {
                    const titleTextCount = document.getElementById('venue-title').value.length;
                    if (titleTextCount < 1) {
                        showModal('Please enter a title for your venue.', undefined, 'black_ico.png');
                        return;
                    } else if (titleTextCount > 50) {
                        showModal('Title should not exceed 50 characters.', undefined, 'black_ico.png');
                        return;
                    }

                    const minGuest = document.getElementById('min-attendees').value;
                    const maxGuest = document.getElementById('max-attendees').value;

                    if (!minGuest) {
                        showModal('Please enter the minimun number of guests.', undefined, 'black_ico.png');
                        return;
                    } else if (minGuest < 1) {
                        showModal('Please enter a valid number of guests.', undefined, 'black_ico.png');
                        return;
                    } else if (minGuest.includes('.')) {
                        showModal('Please enter a whole number for the minimum number of guests.', undefined, 'black_ico.png');
                        return;
                    }

                    if (!maxGuest) {
                        showModal('Please enter the maximum number of guests.', undefined, 'black_ico.png');
                        return;
                    } else if (maxGuest < 1) {
                        showModal('Please enter a valid number of guests.', undefined, 'black_ico.png');
                        return;
                    } else if (maxGuest.includes('.')) {
                        showModal('Please enter a whole number for the maximum number of guests.', undefined, 'black_ico.png');
                        return;
                    }

                }

                if (currentStep === 10) {
                    const price = document.getElementById('price').value;
                    if (!price) {
                        showModal('Please enter a price for your venue.', undefined, 'black_ico.png');
                        return;
                    } else if (price < 1) {
                        showModal('Please enter a valid price for your venue.', undefined, 'black_ico.png');
                        return;
                    } else if (price.includes('.')) {
                        showModal('Please enter a whole number for the price of your venue.', undefined, 'black_ico.png');
                        return;
                    }

                    const minTime = document.getElementById('min-time').value;
                    const maxTime = document.getElementById('max-time').value;

                    if (!minTime) {
                        showModal('Please enter the minimum booking time.', undefined, 'black_ico.png');
                        return;
                    } else if (minTime < 1) {
                        showModal('Please enter a valid minimum booking time.', undefined, 'black_ico.png');
                        return;
                    } else if (minTime.includes('.')) {
                        showModal('Please enter a whole number for the minimum booking time.', undefined, 'black_ico.png');
                        return;
                    }

                    if (!maxTime) {
                        showModal('Please enter the minimum booking time.', undefined, 'black_ico.png');
                        return;
                    } else if (maxTime < 1) {
                        showModal('Please enter a valid minimum booking time.', undefined, 'black_ico.png');
                        return;
                    } else if (maxTime.includes('.')) {
                        showModal('Please enter a whole number for the minimum booking time.', undefined, 'black_ico.png');
                        return;
                    }

                }

                // Add exit animation to current step
                const currentStepElement = document.getElementById(`step${currentStep}`);
                currentStepElement.classList.add('exit');

                // Wait for exit animation to complete
                setTimeout(() => {
                    currentStepElement.classList.remove('active', 'exit');
                    currentStep++;

                    // Show next step
                    const nextStepElement = document.getElementById(`step${currentStep}`);
                    nextStepElement.classList.add('active');

                    updateProgress();
                    updateNavigationButtons();
                }, 300); // Match this with the CSS transition duration
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                // Add exit animation to current step
                const currentStepElement = document.getElementById(`step${currentStep}`);
                currentStepElement.classList.add('exit');

                // Wait for exit animation to complete
                setTimeout(() => {
                    currentStepElement.classList.remove('active', 'exit');
                    currentStep--;

                    // Show previous step
                    const prevStepElement = document.getElementById(`step${currentStep}`);
                    prevStepElement.classList.add('active');

                    updateProgress();
                    updateNavigationButtons();
                }, 300); // Match this with the CSS transition duration
            }
        }

        function updateProgress() {
            const progressBar = document.getElementById('progress');
            const progressPercentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
            progressBar.style.width = `${progressPercentage}%`;
        }

        function updateNavigationButtons() {
            const backButton = document.querySelector('.bottom-0 button:first-child');
            const nextButton = document.querySelector('.bottom-0 button:last-child');

            // Update Back button visibility
            backButton.style.visibility = currentStep === 1 ? 'hidden' : 'visible';

            // Update Next button text for last step
            if (currentStep === totalSteps) {
                nextButton.textContent = 'Publish';
                nextButton.classList.add('bg-green-600', 'hover:bg-green-700');
                nextButton.addEventListener('click', function () {
                    document.getElementById('VenuePostButton').click();
                });
            } else {
                nextButton.textContent = 'Next';
                nextButton.classList.remove('bg-green-600', 'hover:bg-green-700');
            }
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function () {
            // Show first step and hide others
            for (let i = 1; i <= totalSteps; i++) {
                const stepElement = document.getElementById(`step${i}`);
                if (stepElement) {
                    stepElement.classList.toggle('active', i === 1);
                }
            }

            // Initialize progress bar and navigation
            updateProgress();
            updateNavigationButtons();

            // Initialize description field
            const descriptionField = document.getElementById('venue-description');
            if (descriptionField) {
                descriptionField.value = defaultDescription;

                // Clear template on first focus
                let isFirstFocus = true;
                descriptionField.addEventListener('focus', function () {
                    if (isFirstFocus && this.value === defaultDescription) {
                        this.value = '';
                        isFirstFocus = false;
                    }
                });

                // Restore template if field is empty on blur
                descriptionField.addEventListener('blur', function () {
                    if (this.value.trim() === '') {
                        this.value = defaultDescription;
                        isFirstFocus = true;
                    }
                });
            }

            // Add toggle functionality for entrance fee
            const entranceFeeToggle = document.getElementById('entrance-fee-toggle');
            const entranceFeeInput = document.getElementById('entrance-fee-input');

            entranceFeeToggle.addEventListener('change', function () {
                entranceFeeInput.classList.toggle('hidden', !this.checked);
            });

            // Add toggle functionality for cleaning fee
            const cleaningFeeToggle = document.getElementById('cleaning-fee-toggle');
            const cleaningFeeInput = document.getElementById('cleaning-fee-input');

            cleaningFeeToggle.addEventListener('change', function () {
                cleaningFeeInput.classList.toggle('hidden', !this.checked);
            });
        });

        // Add event listeners for venue type selection
        document.querySelectorAll('.grid input').forEach(button => {
            button.addEventListener('click', function () {
                // Remove selected style from all parent labels
                document.querySelectorAll('.grid label').forEach(label => {
                    label.classList.remove('border-black', 'border-2', 'bg-gray-100');
                });

                // Add selected style to the clicked radio button's parent label
                this.parentElement.classList.add('border-black', 'border-2', 'bg-gray-100');
            });
        });

    </script>

    <script>
        // Add event listeners for category selection
        let first = false;
        let second = false;
        let third = false;
        let fourth = false;
        let fifth = false;

        document.getElementById('firstCategoryButton').addEventListener('click', (e) => {
            e.preventDefault();
            if (!first) {
                document.querySelectorAll('.firstCategory input[type="checkbox"]').forEach((checkbox) => {
                    checkbox.checked = true; // Check all checkboxes
                    document.getElementById('firstCategoryLabel').textContent = 'Unselect all';
                    document.getElementById('firstCategoryLabel').classList.add('text-neutral-50')
                    document.getElementById('firstCategoryButtonLabel').classList.add('bg-neutral-950')

                });
                first = true;
            } else {
                document.querySelectorAll('.firstCategory input[type="checkbox"]').forEach((checkbox) => {
                    checkbox.checked = false; // Uncheck all checkboxes
                    document.getElementById('firstCategoryLabel').textContent = 'Select All';
                    document.getElementById('firstCategoryLabel').classList.remove('text-neutral-50');
                    document.getElementById('firstCategoryButtonLabel').classList.remove('bg-neutral-950');
                });
                first = false;
            }
        })

        document.getElementById('secondCategoryButton').addEventListener('click', (e) => {
            e.preventDefault();
            if (!second) {
                document.querySelectorAll('.secondCategory input[type="checkbox"]').forEach((checkbox) => {
                    checkbox.checked = true; // Check all checkboxes
                    document.getElementById('secondCategoryLabel').textContent = 'Unselect all';
                    document.getElementById('secondCategoryLabel').classList.add('text-neutral-50')
                    document.getElementById('secondCategoryButtonLabel').classList.add('bg-neutral-950')

                });
                second = true;
            } else {
                document.querySelectorAll('.secondCategory input[type="checkbox"]').forEach((checkbox) => {
                    checkbox.checked = false; // Uncheck all checkboxes
                    document.getElementById('secondCategoryLabel').textContent = 'Select All';
                    document.getElementById('secondCategoryLabel').classList.remove('text-neutral-50');
                    document.getElementById('secondCategoryButtonLabel').classList.remove('bg-neutral-950');
                });
                second = false;
            }
        })

        document.getElementById('thirdCategoryButton').addEventListener('click', (e) => {
            e.preventDefault();
            if (!third) {
                document.querySelectorAll('.thirdCategory input[type="checkbox"]').forEach((checkbox) => {
                    checkbox.checked = true; // Check all checkboxes
                    document.getElementById('thirdCategoryLabel').textContent = 'Unselect all';
                    document.getElementById('thirdCategoryLabel').classList.add('text-neutral-50')
                    document.getElementById('thirdCategoryButtonLabel').classList.add('bg-neutral-950')

                });
                third = true;
            } else {
                document.querySelectorAll('.thirdCategory input[type="checkbox"]').forEach((checkbox) => {
                    checkbox.checked = false; // Uncheck all checkboxes
                    document.getElementById('thirdCategoryLabel').textContent = 'Select All';
                    document.getElementById('thirdCategoryLabel').classList.remove('text-neutral-50');
                    document.getElementById('thirdCategoryButtonLabel').classList.remove('bg-neutral-950');
                });
                third = false;
            }
        })

        document.getElementById('fourthCategoryButton').addEventListener('click', (e) => {
            e.preventDefault();
            if (!fourth) {
                document.querySelectorAll('.fourthCategory input[type="checkbox"]').forEach((checkbox) => {
                    checkbox.checked = true; // Check all checkboxes
                    document.getElementById('fourthCategoryLabel').textContent = 'Unselect all';
                    document.getElementById('fourthCategoryLabel').classList.add('text-neutral-50')
                    document.getElementById('fourthCategoryButtonLabel').classList.add('bg-neutral-950')

                });
                fourth = true;
            } else {
                document.querySelectorAll('.fourthCategory input[type="checkbox"]').forEach((checkbox) => {
                    checkbox.checked = false; // Uncheck all checkboxes
                    document.getElementById('fourthCategoryLabel').textContent = 'Select All';
                    document.getElementById('fourthCategoryLabel').classList.remove('text-neutral-50');
                    document.getElementById('fourthCategoryButtonLabel').classList.remove('bg-neutral-950');
                });
                fourth = false;
            }
        })
        document.getElementById('fifthCategoryButton').addEventListener('click', (e) => {
            e.preventDefault();
            if (!fifth) {
                document.querySelectorAll('.fifthCategory input[type="checkbox"]').forEach((checkbox) => {
                    checkbox.checked = true; // Check all checkboxes
                    document.getElementById('fifthCategoryLabel').textContent = 'Unselect all';
                    document.getElementById('fifthCategoryLabel').classList.add('text-neutral-50')
                    document.getElementById('fifthCategoryButtonLabel').classList.add('bg-neutral-950')

                });
                fifth = true;
            } else {
                document.querySelectorAll('.fifthCategory input[type="checkbox"]').forEach((checkbox) => {
                    checkbox.checked = false; // Uncheck all checkboxes
                    document.getElementById('fifthCategoryLabel').textContent = 'Select All';
                    document.getElementById('fifthCategoryLabel').classList.remove('text-neutral-50');
                    document.getElementById('fifthCategoryButtonLabel').classList.remove('bg-neutral-950');
                });
                fifth = false;
            }
        })
    </script>


    <script>
        const fileInput = document.getElementById("file-upload");
        const previewContainer = document.getElementById("image-preview-container");
        const imageCountDisplay = document.getElementById("image-count");
        const venueTitleInput = document.getElementById("venue-title");
        const venueTitlePreview = document.getElementById("venue-title-preview");
        const priceInput = document.getElementById("price");
        const pricePreview = document.getElementById("venue-price-preview");

        let uploadedImages = []; // Array to track uploaded images
        let mainImageIndex = null; // Tracks the main image

        // Update venue title in real-time
        venueTitleInput.addEventListener("input", (event) => {
            const titleValue = event.target.value.trim(); // Get the input value and trim spaces
            venueTitlePreview.textContent = titleValue || "Untitled"; // Fallback to 'Untitled' if empty
        });

        // Update price preview in real-time
        priceInput.addEventListener("input", (event) => {
            const priceValue = event.target.value.trim(); // Get the input value and trim spaces
            pricePreview.textContent = `₱${priceValue} per night`; // Display the price with a currency symbol
        });

        // Handle file input changes
        fileInput.addEventListener("change", (event) => {
            const files = Array.from(event.target.files);

            // Update image counter
            imageCountDisplay.textContent = `Uploaded images: ${files.length}`;

            // Clear previous previews
            previewContainer.innerHTML = "";
            uploadedImages = []; // Reset uploaded images array

            // Display preview for each selected file
            files.forEach((file, index) => {
                if (file.type.startsWith("image/")) {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        const imageURL = e.target.result;

                        // Create a wrapper div for each image preview
                        const imageWrapper = document.createElement("div");
                        imageWrapper.className = "relative border rounded-lg overflow-hidden group";

                        // Image element
                        const imgElement = document.createElement("img");
                        imgElement.src = imageURL;
                        imgElement.alt = `Venue Image ${index + 1}`;
                        imgElement.className = "object-contain w-full h-40 border-2";

                        // Main Image Button
                        const mainButton = document.createElement("button");
                        mainButton.textContent = "Set as Main";
                        mainButton.className = "absolute top-2 left-2 bg-blue-500 text-white px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition";
                        mainButton.addEventListener("click", (e) => {
                            e.preventDefault();
                            mainImageIndex = index; // Set index as main
                            console.log("Main image set to index", index);
                            document.getElementById('imageThumbnail').value = index;
                            updateMainImageHighlight();
                        });

                        // Append elements
                        imageWrapper.appendChild(imgElement);
                        imageWrapper.appendChild(mainButton);
                        previewContainer.appendChild(imageWrapper);

                        // Add to uploaded images array
                        uploadedImages.push(file);
                    };

                    reader.readAsDataURL(file);
                } else {
                    showModal("Please select a valid image file.", undefined, 'black_ico.png');
                }
            });
        });

        // Highlight the main image
        function updateMainImageHighlight() {
            const wrappers = previewContainer.querySelectorAll(".relative");
            wrappers.forEach((wrapper, index) => {
                if (index === mainImageIndex) {
                    wrapper.classList.add("ring-4", "ring-blue-500");
                } else {
                    wrapper.classList.remove("ring-4", "ring-blue-500");
                }
            });
        }
    </script>


</body>

</html>