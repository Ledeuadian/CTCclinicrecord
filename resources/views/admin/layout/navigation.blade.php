@extends('admin.layout.app')

@section('navigation')
<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
</button>

<aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
    <x-application-logo class="block h-auto max-w-lg mx-auto fill-current text-gray-800 dark:text-gray-200" />
    <a href="#" class="flex items-center  mx-auto mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
        {{ config('app.name', 'Laravel') }}
    </a>
    <ul class="space-y-2 font-medium">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                </svg>
                <span class="ms-3">Dashboard</span>
            </a>
        </li>
        <li>
            <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-patients" data-collapse-toggle="dropdown-patients">
                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 458 458"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M159.456,273.946l31.567,0.196l-34.62-35.763l60.023,38.559c0.005,0.003,0.009,0.005,0.014,0.008 c4.844,3.105,10.893,3.491,15.99,1.257l62.154-27.256c9.061-3.972,12.927-14.916,8.035-23.779 c-4.193-7.621-13.603-10.875-21.679-7.335l-53.812,23.598l-54.355-34.918l53.506,17.485l48.114-21.099 c16.825-7.378,36.477,0.28,43.862,17.12c7.352,16.766-0.224,36.454-17.12,43.862c-11.214,4.918-8.788,3.854-20.108,8.818 c16.881,0.105,19.466,0.273,24.229-0.171c9.258-0.863,16.258-5.842,19.472-14.42l26.403-70.465 c5.777,7.277,54.071,68.108,60.256,75.899c7.386,9.306,20.921,10.862,30.227,3.473c9.306-7.388,10.86-20.921,3.472-30.227 l-83.905-105.689c-4.821-6.072-12.544-9.08-20.197-7.875c-7.66,1.207-14.078,6.442-16.799,13.703 c-2.338,6.241-17.167,45.816-20.692,55.223c-0.607-0.022-142.98-5.298-143.588-5.298c-11.584,0-20.998,9.356-21.083,20.93 l-0.316,42.925C138.417,264.353,147.804,273.874,159.456,273.946z"></path> <path d="M79.911,272.603c22.085,0.137,39.977-17.695,40.113-39.619c0.136-21.915-17.523-39.976-39.619-40.113 c-22.018-0.136-39.977,17.602-40.113,39.619C40.156,254.508,57.894,272.467,79.911,272.603z"></path> <path d="M439.582,296.207H18.413C8.244,296.207,0,304.451,0,314.62s8.244,18.413,18.413,18.413h421.169 c10.169,0,18.413-8.244,18.413-18.413S449.751,296.207,439.582,296.207z"></path> </g> </g> </g> </g></svg>
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Patients</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <ul id="dropdown-patients" class="hidden py-2 space-y-2">
                  <li>
                     <a href="{{ route('admin.patients.create') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Add Patients</a>
                  </li>
                  <li>
                     <a href="{{ route('admin.patients.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">View Patients</a>
                  </li>
            </ul>
        </li>
        <li>
            <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-health-records" data-collapse-toggle="dropdown-health-records">
                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" viewBox="0 0 32 32" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <g data-name="Layer 15" id="Layer_15"><path d="M29,18H26V7s0,0,0,0a.81.81,0,0,0-.08-.34.36.36,0,0,0,0-.09.92.92,0,0,0-.24-.31l-5-4a.85.85,0,0,0-.28-.15l-.08,0A.62.62,0,0,0,20,2H7A1,1,0,0,0,6,3V15H5a2.73,2.73,0,0,0-3,2.44v9.39C2,28.61,3.76,30,6,30H26c2.24,0,4-1.39,4-3.17V19A1,1,0,0,0,29,18ZM21,5.08,22.15,6H21ZM8,4H19V7a1,1,0,0,0,1,1h4V18H17V16a1,1,0,0,0-1-1H8ZM28,26.83c0,.55-.82,1.17-2,1.17H6c-1.18,0-2-.62-2-1.17V17.44c0-.11.35-.44,1-.44H15v2a1,1,0,0,0,1,1H28Z"/><path d="M18,23H17V22a1,1,0,0,0-2,0v1H14a1,1,0,0,0,0,2h1v1a1,1,0,0,0,2,0V25h1a1,1,0,0,0,0-2Z"/><path d="M11,11H21a1,1,0,0,0,0-2H11a1,1,0,0,0,0,2Z"/><path d="M22,13a1,1,0,0,0-1-1H11a1,1,0,0,0,0,2H21A1,1,0,0,0,22,13Z"/></g>
                </svg>
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Health Records</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <ul id="dropdown-health-records" class="hidden py-2 space-y-2">
                  <li>
                     <a href="{{ route('admin.dental.index')}}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Dental</a>
                  </li>
                  <li>
                     <a href="{{ route('admin.immunization.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Immunization</a>
                  </li>
                  <li>
                    <a href="{{ route('admin.physical.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Physical</a>
                 </li>
                 <li>
                    <a href="{{ route('admin.prescription.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Prescription</a>
                 </li>
            </ul>
        </li>
        <li>
            <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-doctors" data-collapse-toggle="dropdown-doctors">
                <svg  class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 458 458"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M194.409,41.091c4.704,6.39,12.275,10.546,20.8,10.546s16.095-4.156,20.799-10.546h11.084 c-1.778-3.403-4.082-6.485-6.808-9.139c0.482-1.967,0.742-4.02,0.742-6.133C241.026,11.582,229.445,0,215.209,0 s-25.818,11.582-25.818,25.818c0,2.104,0.259,4.147,0.736,6.106c-2.738,2.661-5.053,5.752-6.837,9.167H194.409z M215.209,12.032 c7.602,0,13.786,6.184,13.786,13.786s-6.185,13.786-13.786,13.786c-7.603,0-13.787-6.184-13.787-13.786 C201.421,18.216,207.606,12.032,215.209,12.032z"></path> <path d="M215.19,93.706c19.871,0,35.98-16.109,35.98-35.98c0-0.115-0.008-0.229-0.009-0.344h-71.943 c-0.001,0.115-0.009,0.229-0.009,0.344C179.21,77.597,195.319,93.706,215.19,93.706z"></path> <path d="M320.381,304.328h-11.273v-15.59c5.837-3.354,9.431-9.956,8.603-17.067l-14.764-126.713 c-0.693-22.036-18.889-39.784-41.064-39.784c-3.355,0,3.038,0-93.386,0c-22.54,0-40.97,18.337-41.083,40.878 c0,0.043,0,0.086,0,0.129l0.308,127.542c0.022,9.574,7.791,17.319,17.359,17.319c0.014,0,0.028,0,0.043,0 c9.588-0.023,17.342-7.814,17.318-17.402l-0.308-127.458c0.023-1.895,1.571-3.415,3.465-3.403 c1.894,0.012,3.423,1.551,3.423,3.445v125.323h0.008v166.518c0,11.505,9.327,20.833,20.833,20.833 c11.506,0,20.833-9.327,20.833-20.833V271.546h8.994v166.518c0,11.505,9.327,20.833,20.833,20.833s20.833-9.327,20.833-20.833 c0-275.209-0.369-118.09-0.378-291.3c0-1.912,1.475-3.501,3.382-3.643c1.907-0.142,3.603,1.211,3.884,3.102 c0,0.001,0,0.001,0,0.002c0.21,1.416,0.836,8.111,14.977,129.464c0.681,5.841,4.194,10.65,8.999,13.251v15.387h-11.274 c-6.132,0-11.103,4.971-11.103,11.103v90.94c0,6.132,4.971,11.103,11.103,11.103h39.433c6.132,0,11.103-4.971,11.103-11.103 v-90.939h0.002C331.484,309.299,326.513,304.328,320.381,304.328z"></path> </g> </g> </g> </g></svg>
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Doctors</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <ul id="dropdown-doctors" class="hidden py-2 space-y-2">
                  <li>
                     <a href="{{ route('admin.doctors.create') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Add Doctors</a>
                  </li>
                  <li>
                     <a href="{{ route('admin.doctors.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">View Doctors</a>
                  </li>
            </ul>
        </li>
        <li>
            <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-medicines" data-collapse-toggle="dropdown-medicines">
                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 500 500"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path class="st0" d="M471.199,231.069L271.6,33.725l0.044,0.093C249.149,11.271,219.501-0.05,189.995,0 c-29.463-0.05-59.112,11.271-81.609,33.818c-22.54,22.49-33.857,52.092-33.815,81.609c-0.042,29.502,11.274,59.147,33.815,81.645 l47.106,46.6c-1.42-0.043-2.842-0.043-4.259-0.043c-38.632,0-73.726,9.714-99.984,26.161 c-13.106,8.245-24.057,18.189-31.846,29.782c-7.832,11.55-12.417,24.835-12.417,38.858v78.719c0,14.016,4.585,27.308,12.417,38.858 c11.732,17.364,30.377,31.15,53.107,40.83c22.773,9.664,49.762,15.113,78.723,15.163c38.579-0.05,73.676-9.758,99.93-26.211 c13.149-8.202,24.054-18.188,31.89-29.781c7.793-11.55,12.374-24.842,12.374-38.858v-35.144l12.554,12.425l-0.043-0.1 c22.494,22.54,52.143,33.868,81.648,33.818c29.466,0.05,59.112-11.278,81.612-33.768c22.54-22.548,33.814-52.143,33.814-81.659 C505.013,283.212,493.739,253.609,471.199,231.069z M141.473,148.686c-19.106-19.149-19.106-50.63,0.272-70.009 c9.346-9.349,21.809-14.525,35.102-14.525L141.473,148.686z M29.896,338.43c0.043-9.026,2.839-17.637,8.482-26.075 c4.95-7.37,12.231-14.432,21.347-20.705l175.312,102.594c-3.986,2.194-8.201,4.259-12.65,6.137 c-20.113,8.567-44.672,13.608-71.152,13.608c-35.38,0.05-67.27-9.026-89.764-23.186c-11.27-7.097-20.16-15.4-26.118-24.283 c-2.205-3.305-4.033-6.645-5.456-10.08V338.43z M272.518,417.15c0,9.026-2.842,17.644-8.474,26.068 c-8.438,12.56-23.418,24.196-43.074,32.542c-19.612,8.338-43.715,13.335-69.736,13.335c-34.735,0-66.029-8.94-87.792-22.684 c-10.908-6.832-19.433-14.848-25.064-23.193c-5.642-8.424-8.439-17.042-8.482-26.068v-32.484 c11.087,12.274,26.211,22.498,44.034,30.054c22.268,9.449,48.798,14.854,77.304,14.854c37.983,0,72.44-9.586,98.005-25.623 c8.98-5.586,16.816-12.045,23.279-19.243V417.15z M272.518,356.44c-0.272,0.688-0.552,1.326-0.918,2.014 c-1.233,2.753-2.749,5.406-4.538,8.065c-3.847,5.772-9.026,11.228-15.164,16.311L78.329,281.29c1.054-0.459,2.065-1.011,3.116-1.42 c19.611-8.338,43.715-13.335,69.79-13.335c10.26,0,20.208,0.781,29.689,2.251c22.637,3.434,42.704,10.762,58.054,20.382 c1.878,1.147,3.667,2.388,5.359,3.628c8.294,5.908,14.847,12.46,19.475,19.293c0.093,0.086,0.183,0.179,0.233,0.265 c5.632,8.438,8.474,17.049,8.474,26.075V356.44z M451.77,374.9c-17.228,17.192-39.639,25.752-62.183,25.752 c-22.588,0-44.991-8.524-62.223-25.752l-0.046-0.043l-31.89-31.524v-4.903c0-14.024-4.581-27.309-12.374-38.858 c-9.801-14.432-24.326-26.39-42.016-35.553c2.201-5.728,4.994-11.966,8.432-18.368c9.714-18.246,24.286-38.041,43.578-53.247 c19.196-15.17,42.798-25.982,71.984-27.638l86.692,85.731h0.046c17.182,17.228,25.749,39.683,25.749,62.223 C477.519,335.268,468.952,357.723,451.77,374.9z"></path> </g> </g></svg>
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Medicines</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <ul id="dropdown-medicines" class="hidden py-2 space-y-2">
                  <li>
                     <a href="{{ route('admin.medicines.create') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Add Medicines</a>
                  </li>
                  <li>
                     <a href="{{ route('admin.medicines.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">View Medicines</a>
                  </li>
            </ul>
        </li>
        <li>
            <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-appointments" data-collapse-toggle="dropdown-appointments">
                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"  viewBox="0 0 15 15"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3.5 0V5M11.5 0V5M3 7.5H6M12 7.5H9M3 10.5H6M9 10.5H12M1.5 2.5H13.5C14.0523 2.5 14.5 2.94772 14.5 3.5V13.5C14.5 14.0523 14.0523 14.5 13.5 14.5H1.5C0.947716 14.5 0.5 14.0523 0.5 13.5V3.5C0.5 2.94772 0.947715 2.5 1.5 2.5Z" stroke="#000000"></path> </g></svg>
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Appointments</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <ul id="dropdown-appointments" class="hidden py-2 space-y-2">
                  <li>
                     <a href="{{ route('admin.appointments.create') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Add Appointments</a>
                  </li>
                  <li>
                     <a href="{{ route('admin.appointments.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">View Appointments</a>
                  </li>
            </ul>
        </li>
        <li>
            <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-users" data-collapse-toggle="dropdown-users">
                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                    <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                </svg>
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Users</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <ul id="dropdown-users" class="hidden py-2 space-y-2">
                  <li>
                     <a href="{{ route('admin.users.create') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Add Users</a>
                  </li>
                  <li>
                     <a href="{{ route('admin.users.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">View Users</a>
                  </li>
            </ul>
        </li>
        <li>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M11.75 9.874C11.75 10.2882 12.0858 10.624 12.5 10.624C12.9142 10.624 13.25 10.2882 13.25 9.874H11.75ZM13.25 4C13.25 3.58579 12.9142 3.25 12.5 3.25C12.0858 3.25 11.75 3.58579 11.75 4H13.25ZM9.81082 6.66156C10.1878 6.48991 10.3542 6.04515 10.1826 5.66818C10.0109 5.29121 9.56615 5.12478 9.18918 5.29644L9.81082 6.66156ZM5.5 12.16L4.7499 12.1561L4.75005 12.1687L5.5 12.16ZM12.5 19L12.5086 18.25C12.5029 18.25 12.4971 18.25 12.4914 18.25L12.5 19ZM19.5 12.16L20.2501 12.1687L20.25 12.1561L19.5 12.16ZM15.8108 5.29644C15.4338 5.12478 14.9891 5.29121 14.8174 5.66818C14.6458 6.04515 14.8122 6.48991 15.1892 6.66156L15.8108 5.29644ZM13.25 9.874V4H11.75V9.874H13.25ZM9.18918 5.29644C6.49843 6.52171 4.7655 9.19951 4.75001 12.1561L6.24999 12.1639C6.26242 9.79237 7.65246 7.6444 9.81082 6.66156L9.18918 5.29644ZM4.75005 12.1687C4.79935 16.4046 8.27278 19.7986 12.5086 19.75L12.4914 18.25C9.08384 18.2892 6.28961 15.5588 6.24995 12.1513L4.75005 12.1687ZM12.4914 19.75C16.7272 19.7986 20.2007 16.4046 20.2499 12.1687L18.7501 12.1513C18.7104 15.5588 15.9162 18.2892 12.5086 18.25L12.4914 19.75ZM20.25 12.1561C20.2345 9.19951 18.5016 6.52171 15.8108 5.29644L15.1892 6.66156C17.3475 7.6444 18.7376 9.79237 18.75 12.1639L20.25 12.1561Z"></path> </g></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">{{ __('Log Out') }}</span>
                </a>
            </form>
        </li>
    </ul>
    </div>
</aside>
@endsection
