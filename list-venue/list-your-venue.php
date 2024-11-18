<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Your Venue - HubVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
</head>

<body class="bg-white pb-16 pt-16"> <!-- Added padding-top to account for fixed top bar -->
    <!-- New top bar -->
    <div class="top-bar">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div>
                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation"
                    focusable="false"
                    style="display: block; fill: none; height: 32px; width: 32px; stroke: currentcolor; stroke-width: 4; overflow: visible;">
                    <g fill="none" fill-rule="nonzero">
                        <path d="m2 16h28"></path>
                        <path d="m2 24h28"></path>
                        <path d="m2 8h28"></path>
                    </g>
                </svg>
            </div>
            <div class="flex items-center space-x-4">
                <button class="text-black font-semibold">Questions?</button>
                <button class="bg-black text-white px-4 py-2 rounded-full hover:bg-gray-800">Save & exit</button>
            </div>
        </div>
    </div>

    <div class="container mt-32 mx-auto px-4 py-8 max-w-2xl"> <!-- Adjusted max-width -->
        <div id="step1" class="step active">
            <h2 class="text-2xl font-semibold mb-2">Step 1</h2>
            <h1 class="text-4xl font-bold mb-4">Tell us about your place</h1>
            <p class="text-xl text-gray-600 mb-8">In this step, we'll ask you which type of property you have and if
                guests will book the entire place or just a room. Then let us know the location and how many guests can
                stay.</p>
        </div>



        <div id="step2" class="step">
            <h2 class="text-xl font-semibold mb-4">Which of these best describes your place?</h2>
            <div class="grid grid-cols-3 gap-4">
                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    <h3 class="font-semibold">Corporate Space</h3>
                    <p class="text-sm text-gray-500">Professional venue for meetings, conferences and business events</p>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 15.5458C21 19.5458 12 23.5458 12 23.5458C12 23.5458 3 19.5458 3 15.5458V8.54578C3 7.71778 3.543 6.97178 4.316 6.67278L11.316 4.17278C11.756 4.01978 12.244 4.01978 12.684 4.17278L19.684 6.67278C20.457 6.97178 21 7.71778 21 8.54578V15.5458Z">
                        </path>
                    </svg>
                    <h3 class="font-semibold">Reception Hall</h3>
                    <p class="text-sm text-gray-500">Large spaces perfect for weddings, parties and formal gatherings</p>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <h3 class="font-semibold">Intimate Space</h3>
                    <p class="text-sm text-gray-500">Cozy venues ideal for small gatherings and private events</p>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                        </path>
                    </svg>
                    <h3 class="font-semibold">Outdoor Venue</h3>
                    <p class="text-sm text-gray-500">Beautiful outdoor spaces for events under the sky</p>
                </button>
            </div>
        </div>

        <div id="step3" class="step">
            <h1 class="text-3xl font-bold mb-4">Tell guests what your place has to offer</h1>
            <p class="text-gray-600 mb-6">You can add more amenities after you publish your listing.</p>

            <h2 class="text-xl font-semibold mb-4">What about these guest favorites?</h2>
            <div class="grid grid-cols-3 gap-4 mb-8">
                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M16 20a4 4 0 1 1 0 8 4 4 0 0 1 0-8zm0 2a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm0-7a9 9 0 1 1 0 18 9 9 0 0 1 0-18zm0 2a7 7 0 1 0 0 14 7 7 0 0 0 0-14zm0-13a9 9 0 1 1 0 18 9 9 0 0 1 0-18zm0 2a7 7 0 1 0 0 14 7 7 0 0 0 0-14z"></path>
                    </svg>
                    <span class="block">Wifi</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M9 29v-2h2v-2H6a5 5 0 0 1-5-5v-6a5 5 0 0 1 5-5h20a5 5 0 0 1 5 5v6a5 5 0 0 1-5 5h-5v2h2v2zm0-4h14v-2h-14zm-3-4h20a3 3 0 0 0 3-3v-6a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3zm2-7a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"></path>
                    </svg>
                    <span class="block">TV</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M26 1a5 5 0 0 1 5 5v20a5 5 0 0 1-5 5H6a5 5 0 0 1-5-5V6a5 5 0 0 1 5-5zm0 2H6a3 3 0 0 0-3 3v20a3 3 0 0 0 3 3h20a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3zm-9 20H8v-2h9zm3-6H8v-2h12zm0-6H8V9h12z"></path>
                    </svg>
                    <span class="block">Kitchen</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M26 19a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM7 18a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm20.693-5l.42 1.119C29.253 15.036 30 16.426 30 18v9c0 1.103-.897 2-2 2h-2c-1.103 0-2-.897-2-2v-2H8v2c0 1.103-.897 2-2 2H4c-1.103 0-2-.897-2-2v-9c0-1.574.747-2.964 1.888-3.882L4.308 13H2v-2h3v.152l1.82-4.854A2.009 2.009 0 0 1 8.693 5h14.614c.829 0 1.58.521 1.873 1.297L27 11.151V11h3v2h-2.307zM6 25H4v2h2v-2zm22 0h-2v2h2v-2zm0-2v-5c0-1.654-1.346-3-3-3H7c-1.654 0-3 1.346-3 3v5h24zm-3-10h.557l-2.25-6H8.693l-2.25 6H25zm-15 7h12v-2H10v2z"></path>
                    </svg>
                    <span class="block">Free parking on premises</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M16 1a5 5 0 0 1 5 5v3h3a5 5 0 0 1 5 5v12a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V14a5 5 0 0 1 5-5h3V6a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v3h6V6a3 3 0 0 0-3-3zM8 11a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h16a3 3 0 0 0 3-3V14a3 3 0 0 0-3-3H8zm8 11a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"></path>
                    </svg>
                    <span class="block">Paid parking on premises</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M17 1v4.03l4.026-2.324 1 1.732L17 7.339v6.928l6.026-3.482 1 1.732L17 16.339v4.928l6.026-3.482 1 1.732L17 23.339V32h-2v-8.031l-6.026 3.482-1-1.732L14 22.277v-4.928l-6.026 3.482-1-1.732L14 15.277V8.349L7.974 11.831l-1-1.732L14 6.277V1z"></path>
                    </svg>
                    <span class="block">Air conditioning</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M26 2a1 1 0 0 1 .922.612l.04.113 2 7a1 1 0 0 1-.847 1.269L28 11h-3v5h6v2h-2v13h-2l.001-2.536a3.976 3.976 0 0 1-2.569.983L24 29H8a3.982 3.982 0 0 1-2.569-0.983L5.999 31H4V18H2v-2h6v-5H5a1 1 0 0 1-.96-1.275l.028-.117 2-7a1 1 0 0 1 .847-0.6L7 2h19zm1 16H5v7a2 2 0 0 0 1.697 1.977l.154.018L7 27h18a2 2 0 0 0 1.995-1.85L22 27zm0-6H10v4h12zm-2-5h-8a2 2 0 0 0-1.995 1.85L10 13v1h12v-1a2 2 0 0 0-2-2zm-3-4h-2v2h2z"></path>
                    </svg>
                    <span class="block">Dedicated workspace</span>
                </button>
            </div>

            <h2 class="text-xl font-semibold mb-4">Do you have any standout amenities?</h2>
            <div class="grid grid-cols-3 gap-4 mb-8">
                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M24 26c.988 0 1.945.351 2.671 1.009.306.276.71.445 1.142.483L28 27.5v2l-.228-.006a3.96 3.96 0 0 1-2.443-1.003A1.978 1.978 0 0 0 24 28c-.502 0-.978.175-1.328.491a3.977 3.977 0 0 1-2.67 1.009 3.977 3.977 0 0 1-2.672-1.009A1.978 1.978 0 0 0 16 28c-.503 0-.98.175-1.329.491a3.978 3.978 0 0 1-2.67 1.009 3.978 3.978 0 0 1-2.672-1.009A1.978 1.978 0 0 0 8 28c-.503 0-.98.175-1.33.491a3.96 3.96 0 0 1-2.442 1.003L4 29.5v-2l.187-.008a1.953 1.953 0 0 0 1.142-.483A3.975 3.975 0 0 1 8 26c.988 0 1.945.352 2.671 1.009.35.316.826.491 1.33.491.502 0 .979-.175 1.328-.491A3.974 3.974 0 0 1 16 26c.988 0 1.945.351 2.671 1.009.35.316.826.491 1.33.491.502 0 .979-.175 1.328-.491A3.975 3.975 0 0 1 24 26zm0-5c.988 0 1.945.351 2.671 1.009.306.276.71.445 1.142.483L28 22.5v2l-.228-.006a3.96 3.96 0 0 1-2.443-1.003A1.978 1.978 0 0 0 24 23c-.502 0-.978.175-1.328.491a3.977 3.977 0 0 1-2.67 1.009 3.977 3.977 0 0 1-2.672-1.009A1.978 1.978 0 0 0 16 23c-.503 0-.98.175-1.329.491a3.978 3.978 0 0 1-2.67 1.009 3.978 3.978 0 0 1-2.672-1.009A1.978 1.978 0 0 0 8 23c-.503 0-.98.175-1.33.491a3.96 3.96 0 0 1-2.442 1.003L4 24.5v-2l.187-.008a1.953 1.953 0 0 0 1.142-.483A3.975 3.975 0 0 1 8 21c.988 0 1.945.352 2.671 1.009.35.316.826.491 1.33.491.502 0 .979-.175 1.328-.491A3.974 3.974 0 0 1 16 21c.988 0 1.945.351 2.671 1.009.35.316.826.491 1.33.491.502 0 .979-.175 1.328-.491A3.975 3.975 0 0 1 24 21zm0-5c.988 0 1.945.351 2.671 1.009.306.276.71.445 1.142.483L28 17.5v2l-.228-.006a3.96 3.96 0 0 1-2.443-1.003A1.978 1.978 0 0 0 24 18c-.502 0-.978.175-1.328.491a3.977 3.977 0 0 1-2.67 1.009 3.977 3.977 0 0 1-2.672-1.009A1.978 1.978 0 0 0 16 18c-.503 0-.98.175-1.329.491a3.978 3.978 0 0 1-2.67 1.009 3.978 3.978 0 0 1-2.672-1.009A1.978 1.978 0 0 0 8 18c-.503 0-.98.175-1.33.491a3.96 3.96 0 0 1-2.442 1.003L4 19.5v-2l.187-.008a1.953 1.953 0 0 0 1.142-.483A3.975 3.975 0 0 1 8 16c.988 0 1.945.352 2.671 1.009.35.316.826.491 1.33.491.502 0 .979-.175 1.328-.491A3.974 3.974 0 0 1 16 16c.988 0 1.945.351 2.671 1.009.35.316.826.491 1.33.491.502 0 .979-.175 1.328-.491A3.975 3.975 0 0 1 24 16z"></path>
                    </svg>
                    <span class="block">Pool</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M9.5 2a4.5 4.5 0 0 1 3.527 7.295c.609.215 1.173.55 1.66.988l.191.182L17.414 13H31v2h-2v14a2 2 0 0 1-1.85 1.995L27 31H5a2 2 0 0 1-1.995-1.85L3 29V15H1v-2h2.1a5.009 5.009 0 0 1 2.955-3.608A4.5 4.5 0 0 1 9.5 2zm7.5 13H5v14h22V15h-10.1l2.1 2.1-1.4 1.4-4.1-4.1zm-7.5-11a2.5 2.5 0 0 0-1.849 4.18l.137.143.114.103a4.99 4.99 0 0 1 3.096-.425A2.5 2.5 0 0 0 9.5 4z"></path>
                    </svg>
                    <span class="block">Hot tub</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M23 1a2 2 0 0 1 1.995 1.85L25 3v16h4v2h-2v8h-2v-8h-4v-2h4V3h-2V1zM9 1a2 2 0 0 1 1.995 1.85L11 3v16h4v2h-4v8H9v-8H5v-2h4V3H7V1zm14 2H9v15h14zm-7 8a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                    </svg>
                    <span class="block">Patio</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M12.994 2h2c-.002 2.062-.471 3.344-1.765 5.424l-.753 1.183c-.867 1.391-1.278 2.301-1.418 3.393H9.043c.1-1.069.378-1.966.903-3H6c0 5.523 4.477 10 10 10 5.43 0 9.848-4.327 9.996-9.72L26 9l-3.765.001c-.704 1.177-1.05 2.014-1.177 2.999h-2.015c.15-1.613.708-2.836 1.91-4.728l.563-.88c1.116-1.791 1.477-2.784 1.478-4.393h2c-.002 1.919-.408 3.162-1.506 5L28 7v2c0 .682-.057 1.35-.166 2H30v2h-2.683a12.039 12.039 0 0 1-5.896 6.709l4.49 9.877-1.821.828-2.006-4.415H17V30h-2v-4H9.916L7.91 30.415l-1.821-.828 4.49-9.877A12.039 12.039 0 0 1 4.682 13H2v-2h2.166a12.058 12.058 0 0 1-.162-1.695L4 9V7l7.298.001c-1.1-1.84-1.506-3.064-1.506-4.984V2h.389c1.296 0 2.041.26 3.537 1.603l.726.654c1.639 1.479 2.342 2.481 2.548 4.743H12.994z"></path>
                    </svg>
                    <span class="block">BBQ grill</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M29 15v16h-2v-6h-6v6h-2v-6.333a3.001 3.001 0 0 1-2 0V31h-2v-6h-6v6H7V15H3v-2h2v-2h2V9h2V7h2V5h2V3h10v2h2v2h2v2h2v2h2v2h2v2zM17 3h-2v2h2zm0 4h-2v2h2zm0 4h-2v2h2zm0 4h-2v2h2zM9 19h14v2H9zm14-4H9v2h14z"></path>
                    </svg>
                    <span class="block">Outdoor dining area</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M27 3a2 2 0 0 1 1.995 1.85L29 5v6h-2V5h-7v14h7v-5h2v11a2 2 0 0 1-1.85 1.995L27 27h-7v2h-8v-2h-7a2 2 0 0 1-1.995-1.85L3 25V5a2 2 0 0 1 1.85-1.995L5 3zm0 16h-7v6h7zm-16-5a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm0 2a1 1 0 1 0 0 2 1 1 0 0 0 0-2zM5 5v20h7v-6.674a5 5 0 1 1 2 0V25h7V5z"></path>
                    </svg>
                    <span class="block">Fire pit</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M31 9v21h-2v-2H3v2H1V9h2v18h26V9h2zM15 1v8h-3l4.5 7L21 9h-3V1z"></path>
                    </svg>
                    <span class="block">Pool table</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M31 6v2h-1v23h-2V8h-1V6zm-5 16v2h-2v7h-2v-7h-2v-2zM5 14v2H3v10H1V14zm20 5v2h-2v9h-2v-9h-2v-2zm-5-3v2h-2v12h-2V18h-2v-2zm-5-5v2h-2v17h-2V13h-2v-2z"></path>
                    </svg>
                    <span class="block">Indoor fireplace</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M9 1v2h14V1h2v2h4v4h2v2h-2v18h-2v-2h-4v2h-2v-2H11v2H9v-2H5v2H3V9H1V7h2V3h4V1zm4 4H9v2H5v18h4v-2h14v2h4V7h-4V5h-4v2h-2V5zm-1 4h12v12H12zm2 2v8h8V9z"></path>
                    </svg>
                    <span class="block">Piano</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M20 1v2h-3v2h1a2 2 0 0 1 1.995 1.85L20 7v2a4 4 0 0 1 3.995 3.8L24 13v14a4 4 0 0 1-3.8 3.995L20 31h-8a4 4 0 0 1-3.995-3.8L8 27V13a4 4 0 0 1 3.8-3.995L12 9V7a2 2 0 0 1 1.85-1.995L14 5h1V3h-3V1zm2 21H10v5a2 2 0 0 0 1.697 1.977l.154.018L7 27h18a2 2 0 0 0 1.995-1.85L22 27zm0-6H10v4h12zm-2-5h-8a2 2 0 0 0-1.995 1.85L10 13v1h12v-1a2 2 0 0 0-2-2zm-3-4h-2v2h2z"></path>
                    </svg>
                    <span class="block">Exercise equipment</span>
                </button>
            </div>

            <h2 class="text-xl font-semibold mt-8 mb-4">Do you have any of these safety items?</h2>
            <div class="grid grid-cols-3 gap-4">
                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M16 1c8.284 0 15 6.716 15 15 0 8.284-6.716 15-15 15-8.284 0-15-6.716-15-15C1 7.716 7.716 1 16 1zm0 2C8.82 3 3 8.82 3 16s5.82 13 13 13 13-5.82 13-13S23.18 3 16 3zm-4.9 14.05l.1-.05a1 1 0 0 1 .474-.095l.126.008c.167.024.314.065.45.124l4.75 2.374V12c0-.552.448-1 1-1s1 .448 1 1v7.412l4.75-2.374a1 1 0 0 1 .617-.157l.133.027c.306.085.54.325.617.632l.025.127a1 1 0 0 1-.096.623l-.055.095-5.85 7.8a1 1 0 0 1-.617.358l-.133.008a1 1 0 0 1-.617-.157l-.112-.083-5.85-7.8a1 1 0 0 1 .02-1.214z"></path>
                    </svg>
                    <span class="block">Smoke alarm</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M26 3a5 5 0 0 1 4.995 4.783L31 8v16a5 5 0 0 1-4.783 4.995L26 29H6a5 5 0 0 1-4.995-4.783L1 24V8a5 5 0 0 1 4.783-4.995L6 3zm0 2H6a3 3 0 0 0-2.995 2.824L3 8v16a3 3 0 0 0 2.824 2.995L6 27h20a3 3 0 0 0 2.995-2.824L29 24V8a3 3 0 0 0-2.824-2.995zm-7 4v2H8V8zm0 4v2H8v-2zm0 4v2H8v-2zm0 4v2H8v-2z"></path>
                    </svg>
                    <span class="block">First aid kit</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M7 28H5V15c0-4.997 3.356-9.304 8.061-10.603A3 3 0 0 1 17.69 2h.618a3 3 0 0 1 4.63 2.397C27.644 5.696 31 10.003 31 15v13h-2V15c0-4.418-2.953-8.315-7.188-9.5a3.001 3.001 0 0 1-5.624 0C11.953 6.685 9 10.582 9 15v13zm0 2h18v2H7v-2z"></path>
                    </svg>
                    <span class="block">Fire extinguisher</span>
                </button>

                <button class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" viewBox="0 0 32 32">
                        <path d="M25 2a5 5 0 0 1 4.995 4.783L30 7v18a5 5 0 0 1-4.783 4.995L25 30H7a5 5 0 0 1-4.995-4.783L2 25V7a5 5 0 0 1 4.783-4.995L6 2zm0 2H6a3 3 0 0 0-2.995 2.824L3 7v18a3 3 0 0 0 2.824 2.995L6 28h18a3 3 0 0 0 2.995-2.824L29 25V7a3 3 0 0 0-2.824-2.995zm-1 4v2H8V8zm0 4v2H8v-2zm0 4v2H8v-2zm0 4v2H8v-2z"></path>
                    </svg>
                    <span class="block">Carbon monoxide alarm</span>
                </button>
            </div>
        </div>

        <div id="step4" class="step">
            <h1 class="text-3xl font-bold mb-4">Where's your place located?</h1>
            <p class="text-gray-600 mb-6">Your address is only shared with guests after they've made a reservation.</p>

            <div class="bg-blue-200 rounded-lg p-6 mb-6">
                <div class="bg-white rounded-full p-3 mb-4">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <input type="text" placeholder="Enter your address" class="w-full outline-none text-gray-700" />
                    </div>
                </div>
                <div class="w-full h-64 bg-blue-300 rounded-lg">
                    <!-- This is a placeholder for the map. You might want to integrate a real map service here -->
                    <img src="path_to_map_image.jpg" alt="Map" class="w-full h-full object-cover rounded-lg" />
                </div>
            
            </div>
        </div>

        <div id="step5" class="step">
        <h2 class="text-2xl font-semibold mb-2">Step 2</h2>
            <h1 class="text-4xl font-bold mb-4">What kind of place will you host?</h1>
            <p class="text-xl text-gray-600 mb-8">Choose the option that best describes your place.</p>
        </div>

        <div id="step6" class="step">
            <h1 class="text-4xl font-bold mb-4">Add photos of your venue</h1>
            <p class="text-xl text-gray-600 mb-8">Photos help guests imagine staying in your place. You can start with one and add more after you publish.</p>
            
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                <div class="space-y-4">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <div class="text-gray-600">
                        <label for="file-upload" class="relative cursor-pointer">
                            <span class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">Upload from your device</span>
                            <input id="file-upload" type="file" class="sr-only" multiple accept="image/*">
                        </label>
                    </div>
                    <p class="text-gray-500">Upload at least 5 photos</p>
                </div>
            </div>
        </div>

        <div id="step7" class="step">
            <h1 class="text-4xl font-bold mb-4">Create your description</h1>
            <p class="text-gray-600 mb-8">Share what makes your place special.</p>
            
            <div class="space-y-6">
                <div>
                    <textarea id="venue-description" 
                              class="w-full p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black" 
                              rows="12" 
                              placeholder="Tell guests what you love about your venue and what makes it unique..."
                    ></textarea>
                    <p class="text-gray-500 text-sm mt-2">Minimum 100 characters</p>
                </div>
            </div>
        </div>

        <div id="step8" class="step">
            <h1 class="text-4xl font-bold mb-4">Create your title</h1>
            <p class="text-gray-600 mb-8">Catch guests' attention with a listing title that highlights what makes your place special.</p>
            
            <div class="space-y-6">
                <div>
                    <input type="text" class="w-full p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black" placeholder="Enter title">
                    <p class="text-gray-500 text-sm mt-2">50 characters maximum</p>
                </div>
            </div>
        </div>

        <div id="step9" class="step">
            <h2 class="text-2xl font-semibold mb-2">Step 3</h2>
            <h1 class="text-4xl font-bold mb-4">Finish up and publish</h1>
            <p class="text-xl text-gray-600 mb-8">Finally, you'll choose booking settings, set up pricing, and publish
                your listing.</p>
        </div>

        <div id="step10" class="step">
            <h1 class="text-4xl font-bold mb-4">Set your house rules</h1>
            <p class="text-gray-600 mb-8">Let guests know what they can expect when booking your venue.</p>

            <div class="space-y-6">
                <div class="space-y-4">
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-black">
                        <span>No smoking</span>
                    </label>
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-black">
                        <span>No parties or events</span>
                    </label>
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-black">
                        <span>No pets</span>
                    </label>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-2">Additional rules (optional)</h3>
                    <textarea class="w-full p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black" rows="4" placeholder="Add any other rules or guidelines..."></textarea>
                </div>
            </div>
        </div>

        <div id="step11" class="step">
            <h1 class="text-3xl font-bold mb-2">Now, set your price</h1>
            <p class="text-gray-600 mb-6">You can change it anytime.</p>

            <div class="text-center mb-8">
                <h2 class="text-6xl font-bold mb-2">₱2,341</h2>
                <p class="text-gray-600">Guest price before taxes ₱2,671 <span class="text-black">▼</span></p>
            </div>

            <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-center mb-8">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Similar listings ₱2,176 - ₱3,263</span>
            </div>
        </div>

        <div id="step12" class="step">
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
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gray-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                        </label>
                    </div>
                    <div id="entrance-fee-input" class="hidden">
                        <div class="flex items-center space-x-4">
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-2 text-gray-500">₱</span>
                                <input type="number" class="w-full pl-8 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black" placeholder="0">
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
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gray-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                        </label>
                    </div>
                    <div id="cleaning-fee-input" class="hidden">
                        <div class="flex items-center space-x-4">
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-2 text-gray-500">₱</span>
                                <input type="number" class="w-full pl-8 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black" placeholder="0">
                            </div>
                            <span class="text-gray-600">one-time fee</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="step13" class="step">
            <h1 class="text-3xl font-bold mb-4">Review your listing</h1>
            <p class="text-gray-600 mb-6">Here's what we'll show to guests. Make sure everything looks good.</p>

            <div class="bg-gray-100 rounded-lg p-4 mb-8">
                <button class="bg-white text-black font-semibold py-2 px-4 rounded">Show preview</button>
                <img src="path_to_map_image.jpg" alt="Map" class="w-full mt-4 rounded">
                <div class="mt-4">
                    <h2 class="text-xl font-semibold">asdas</h2>
                    <p class="text-gray-600"><span class="line-through">₱2,341</span> ₱1,873 night <span
                            class="bg-gray-200 text-gray-800 px-2 py-1 rounded-full text-xs">New</span></p>
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
                        <p class="text-gray-600">We'll let you know if you need to verify your identity or register with
                            the local government.</p>
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
                        <p class="text-gray-600">Choose which dates your listing is available. It will be visible 24
                            hours after you publish.</p>
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
                        <p class="text-gray-600">Set house rules, select a cancellation policy, choose how guests book,
                            and more.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white border-t">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <button onclick="prevStep()" class="text-black font-semibold hover:underline">Back</button>
            <div class="progress-bar w-1/3">
                <div id="progress" class="progress" style="width: 7.14%;"></div>
            </div>
            <button onclick="nextStep()"
                class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800">Next</button>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 13;

        // Replace the existing defaultDescription with this new version
        const defaultDescription = `A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.`;

        function nextStep() {
            if (currentStep < totalSteps) {
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
            } else {
                nextButton.textContent = 'Next';
                nextButton.classList.remove('bg-green-600', 'hover:bg-green-700');
            }
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
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
                descriptionField.addEventListener('focus', function() {
                    if (isFirstFocus && this.value === defaultDescription) {
                        this.value = '';
                        isFirstFocus = false;
                    }
                });

                // Restore template if field is empty on blur
                descriptionField.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.value = defaultDescription;
                        isFirstFocus = true;
                    }
                });
            }

            // Add toggle functionality for entrance fee
            const entranceFeeToggle = document.getElementById('entrance-fee-toggle');
            const entranceFeeInput = document.getElementById('entrance-fee-input');
            
            entranceFeeToggle.addEventListener('change', function() {
                entranceFeeInput.classList.toggle('hidden', !this.checked);
            });

            // Add toggle functionality for cleaning fee
            const cleaningFeeToggle = document.getElementById('cleaning-fee-toggle');
            const cleaningFeeInput = document.getElementById('cleaning-fee-input');
            
            cleaningFeeToggle.addEventListener('change', function() {
                cleaningFeeInput.classList.toggle('hidden', !this.checked);
            });
        });

        // Add event listeners for venue type selection
        document.querySelectorAll('.grid button').forEach(button => {
            button.addEventListener('click', function() {
                // Remove selected style from all buttons
                document.querySelectorAll('.grid button').forEach(btn => {
                    btn.classList.remove('border-black', 'border-2');
                });
                // Add selected style to clicked button
                this.classList.add('border-black', 'border-2');
            });
        });
    </script>
</body>

</html>
