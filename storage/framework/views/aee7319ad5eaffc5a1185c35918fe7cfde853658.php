<!DOCTYPE html>
<html>
<head>
  <title>Therapist Dashboard</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .sidebar {
      width: 200px;
      transition: width 0.3s ease;
    }

    .sidebar.collapsed {
      width: 60px;
    }

    .toggle-button {
      position: fixed;
      left: 200px;
      top: 20px;
      background-color: #111827;
      color: white;
      width: 24px;
      height: 24px;
      border-radius: 0 6px 6px 0;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: left 0.3s ease;
      z-index: 1000;
    }

    .toggle-button.collapsed {
      left: 60px;
    }

    .toggle-button::before {
      content: "◀";
      font-size: 12px;
      transition: transform 0.3s ease;
    }

    .toggle-button.collapsed::before {
      transform: rotate(180deg);
    }

    .main-content {
      margin-left: 200px;
      transition: margin-left 0.3s ease;
    }

    .main-content.collapsed {
      margin-left: 60px;
    }

    .close {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
      font-size: 18px;
      color: #333;
      transition: color 0.3s ease, transform 0.3s ease;
    }

    .close:hover {
      transform: scale(1.2);
    }

    .cancel-btn,
    .reschedule-btn {
      display: none;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: white;
      color: black !important;
      min-width: 150px;
      box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
      padding: 12px 16px;
      z-index: 1000;
      border-radius: 6px;
    }

    .dropdown-content a {
      color: black !important;
      padding: 8px 12px;
      text-decoration: none;
      display: block;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      transition: background-color 0.3s ease;
    }

    .dropdown-content a:last-child {
      border-bottom: none;
    }

    .dropdown-content a:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    #reschedule-modal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1100;
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
      max-width: 400px;
      width: 90%;
    }

    .hidden {
      display: none;
    }

    .modal-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
    }

    form {
      color: black !important;
    }
  </style>
</head>
<body class="bg-gray-100">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar h-screen fixed left-0 top-0 bg-gradient-to-b from-sky-100 to-sky-200 overflow-x-hidden pt-5 transition-all duration-300 border-r border-sky-300 shadow-lg">
      <div class="flex items-center justify-between p-4">
        <h2 class="text-xl font-semibold flex items-center gap-2">
          <i class="fas fa-user-md"></i>
          <span class="sidebar-text">Therapist</span>
        </h2>
        <div id="toggle-button" onclick="toggleSidebar()" class="toggle-button">
          <span class="arrow"></span>
        </div>
      </div>
      <ul class="mt-4">
        <li>
          <a href="#" onclick="showSection('dashboard')" class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 transition-colors">
            <i class="fas fa-home"></i>
            <span class="sidebar-text">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="#" onclick="showSection('calendar')" class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 transition-colors">
            <i class="fas fa-calendar-alt"></i>
            <span class="sidebar-text">Calendar</span>
          </a>
        </li>
        <li>
          <a href="#" onclick="showSection('patients')" class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 transition-colors">
            <i class="fas fa-users"></i>
            <span class="sidebar-text">Patients</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="main-content flex-1">
      <header class="bg-white shadow">
        <div class="flex justify-between items-center px-6 py-4">
          <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
          <div class="flex items-center gap-4">
            <span class="text-gray-600">Welcome, Dr. [Name]</span>
            <span id="current-date" class="text-gray-600"></span>
            <button class="text-gray-600 hover:text-gray-800">
              <i class="fas fa-bell"></i>
            </button>
          </div>
        </div>
      </header>

      <main class="p-6">
        <!-- Dashboard Section -->
        <div id="dashboard" class="section grid grid-cols-1 md:grid-cols-3 gap-6">
          <div onclick="showSection('calendar')" class="bg-white rounded-lg shadow p-6 cursor-pointer hover:-translate-y-1 transition-transform">
            <i class="fas fa-calendar-check text-blue-500 text-2xl mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Appointments</h3>
            <p class="text-gray-600">View and manage your appointments.</p>
          </div>
          <div onclick="showSection('patients')" class="bg-white rounded-lg shadow p-6 cursor-pointer hover:-translate-y-1 transition-transform">
            <i class="fas fa-user-clock text-green-500 text-2xl mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Patients Waiting</h3>
            <p class="text-gray-600">See patients waiting in the waiting room.</p>
          </div>
          <div class="bg-white rounded-lg shadow p-6 cursor-pointer hover:-translate-y-1 transition-transform">
            <i class="fas fa-tasks text-purple-500 text-2xl mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Tasks/Reminders</h3>
            <p class="text-gray-600">Manage your tasks and reminders.</p>
          </div>
        </div>

        <!-- Calendar Section -->
        <div id="calendar" class="section hidden">
          <div class="bg-white rounded-lg shadow p-6">
            <div class="calendar-container"></div>
          </div>
        </div>

        <!-- Patients Section -->
        <div id="patients" class="section hidden">
          <div class="bg-white rounded-lg shadow p-6">
            <header>
              <h3 class="text-xl font-semibold mb-4">Patients Waiting</h3>
            </header>
            <table class="min-w-full bg-white border-collapse">
              <thead>
                <tr>
                  <th class="py-2 border">Child Name</th>
                  <th class="py-2 border">Registration Number</th>
                  <th class="py-2 border">Visit Date/Time</th>
                  <th class="py-2 border">Actions</th>
                </tr>
              </thead>
              <tbody id="patient-table-body">
                <!-- Data will be dynamically populated -->
              </tbody>
            </table>
            <button
              id="startConsultationBtn"
              onclick="startConsultation()"
              class="mt-6 bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition-colors"
            >
              Start Consultation
            </button>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Modal Overlay -->
  <div class="modal-overlay"></div>

  <!-- Reschedule Modal -->
  <div id="reschedule-modal" class="hidden">
    <div class="close" onclick="closeModal('reschedule-modal')">&times;</div>
    <h3 class="text-xl font-semibold mb-4">Reschedule Appointment</h3>
    <!-- Add modal content here -->
  </div>

  <script>
    // Global variables
    let selectedPatient = null;
    let selectedRegistrationNumber = null;
    let sidebarExpanded = true;

    // DOM Content Loaded Event Handler
    document.addEventListener('DOMContentLoaded', () => {
      // Initialize patient list
      generatePatientList();
      
      // Modal event handlers
      const closeModalButton = document.getElementById('close-modal');
      const modal = document.getElementById('add-event-wrapper');
      const modalOverlay = document.querySelector('.modal-overlay');

      if (closeModalButton) {
        closeModalButton.addEventListener('click', () => {
          modal.classList.add('hidden');
          if (modalOverlay) modalOverlay.style.display = 'none';
        });
      }

      // Initialize dashboard
      showSection('dashboard');
      updateDateTime();
      setInterval(updateDateTime, 1000);
    });

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const toggleButton = document.getElementById('toggle-button');
      const mainContent = document.getElementById('main-content');
      
      sidebar.classList.toggle('collapsed');
      toggleButton.classList.toggle('collapsed');
      mainContent.classList.toggle('collapsed');
    }

    function generateCalendar() {
      const calendarContainer = document.querySelector('.calendar-container');
      const today = new Date();
      const currentMonth = today.getMonth();
      const currentYear = today.getFullYear();

      const firstDay = new Date(currentYear, currentMonth, 1).getDay();
      const daysInMonth = 32 - new Date(currentYear, currentMonth, 32).getDate();

      let tableHtml = '<table class="w-full border-collapse">';
      tableHtml += '<tr class="bg-gray-50"><th class="p-2 border">Sun</th><th class="p-2 border">Mon</th><th class="p-2 border">Tue</th><th class="p-2 border">Wed</th><th class="p-2 border">Thu</th><th class="p-2 border">Fri</th><th class="p-2 border">Sat</th></tr><tr>';

      let date = 1;
      for (let i = 0; i < 6; i++) {
        for (let j = 0; j < 7; j++) {
          if (i === 0 && j < firstDay) {
            tableHtml += '<td class="p-2 border"></td>';
          } else if (date > daysInMonth) {
            tableHtml += '<td class="p-2 border"></td>';
          } else {
            const currentDate = new Date(currentYear, currentMonth, date);
            const formattedDate = currentDate.toLocaleDateString('en-US', {
              month: 'short',
              day: 'numeric'
            });
            tableHtml += `<td class="p-2 border cursor-pointer hover:bg-gray-100" onclick="showAppointments('${formattedDate}')">${formattedDate}</td>`;
            date++;
          }
        }
        if (date > daysInMonth) {
          break;
        } else {
          tableHtml += '</tr><tr>';
        }
      }
      tableHtml += '</tr></table>';
      calendarContainer.innerHTML = tableHtml;
    }

    function generatePatientList() {
      const patientTableBody = document.getElementById("patient-table-body");
      if (!patientTableBody) return;
      
      patientTableBody.innerHTML = ""; // Clear existing rows

      // This should be replaced with actual data when integrating with Laravel
      // For now, using a placeholder array
      const visits = <?php echo json_encode($visits, 15, 512) ?>; // Use Laravel's Blade directive to pass data

      console.log(visits); // Log visits data to verify

      visits.forEach((visit) => {
        let fullNameString = '';
        try {
          const fullname = JSON.parse(visit.fullname);
          fullNameString = fullname
            ? `${fullname.first_name} ${fullname.middle_name || ""} ${fullname.last_name}`
            : visit.fullname;
        } catch (e) {
          fullNameString = visit.fullname; // Fallback if parsing fails
        }

        const row = document.createElement("tr");
        row.innerHTML = `
          <td class="py-2 border">${fullNameString}</td>
          <td class="py-2 border">${visit.registration_number}</td>
          <td class="py-2 border">${visit.created_at}</td>
          <td class="py-2 border">
            <button class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600" 
              onclick="selectRegistrationNumber('${visit.registration_number}', '${visit.child_id}')">
              Select
            </button>
          </td>
        `;
        patientTableBody.appendChild(row);
      });
    }

    function selectRegistrationNumber(registrationNumber, childId) {
      selectedRegistrationNumber = registrationNumber;
      console.log(`Selected Registration Number: ${registrationNumber}, Child ID: ${childId}`);
      highlightSelectedRow(registrationNumber);
    }

    function highlightSelectedRow(registrationNumber) {
      const patientTableBody = document.getElementById("patient-table-body");
      const rows = patientTableBody.querySelectorAll("tr");      rows.forEach(row => {
        row.classList.remove("bg-blue-50", "border-l-4", "border-blue-500");
        if (row.children[1].textContent === registrationNumber) {
          row.classList.add("bg-blue-50", "border-l-4", "border-blue-500");
        }
      });
    }

    function showSection(sectionId) {
      const sections = document.querySelectorAll('.section');
      sections.forEach(section => {
        section.classList.add('hidden');
      });
      document.getElementById(sectionId).classList.remove('hidden');

      if (sectionId === 'calendar') {
        generateCalendar();
      } else if (sectionId === 'patients') {
        generatePatientList();
      }

      if (document.getElementById('appointments-list')) {
        document.getElementById('appointments-list').classList.add('hidden');
      }
    }

    function showAppointments(date) {
      const appointmentsList = document.getElementById('appointments-for-day');
      if (appointmentsList) {
        appointmentsList.innerHTML = `<li class="p-3 bg-gray-50 rounded">No patients booked for ${date}</li>`;
        document.getElementById('appointments-list').classList.remove('hidden');
      }
    }

    function updateDateTime() {
      const currentDate = document.getElementById('current-date');
      if (currentDate) {
        const now = new Date();
        currentDate.textContent = now.toLocaleString();
      }
    }

    async function startConsultation() {
      if (!selectedRegistrationNumber) {
        alert('Please select a patient first.');
        return;
      }

      showLoadingIndicator();
      try {
        // Update loading progress
        updateLoadingProgress(20, 'Checking patient data...');
        
        // First make an AJAX call to check if the patient exists and get initial data
        const response = await fetch(`/occupationaltherapy_dashboard/${selectedRegistrationNumber}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        // Update loading progress
        updateLoadingProgress(50, 'Fetching data from server...');

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        
        // Update loading progress
        updateLoadingProgress(80, 'Processing data...');
        
        // If we successfully got the data, redirect to the dashboard page
        window.location.href = `/occupationaltherapy_dashboard/${selectedRegistrationNumber}`;

      } catch (error) {
        console.error('Error starting consultation:', error);
        let errorMessage = 'Error starting consultation. ';
        
        if (error.message.includes('404')) {
          errorMessage += 'Patient not found.';
        } else if (error.message.includes('403')) {
          errorMessage += 'Access denied.';
        } else {
          errorMessage += 'Please try again or contact support.';
        }
        
        alert(errorMessage);
      } finally {
        hideLoadingIndicator();
      }
    }

    // Loading indicator functions
    function showLoadingIndicator() {
      const loader = document.createElement('div');
      loader.id = 'loading-indicator';
      loader.className = 'fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50';
      loader.innerHTML = `
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
          <div id="loading-text" class="mt-4 text-center text-white">Loading...</div>
          <div id="loading-progress" class="mt-2 w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
          </div>
        </div>
      `;
      document.body.appendChild(loader);
    }

    function hideLoadingIndicator() {
      const loader = document.getElementById('loading-indicator');
      if (loader) {
        loader.remove();
      }
    }

    function updateLoadingProgress(percentage, message) {
      const progressBar = document.querySelector('#loading-progress > div');
      const loadingText = document.getElementById('loading-text');
      if (progressBar) {
        progressBar.style.width = `${percentage}%`;
      }
      if (loadingText && message) {
        loadingText.textContent = message;
      }
    }

    // Modal functions
    function closeModal(modalId) {
      const modal = document.getElementById(modalId);
      const modalOverlay = document.querySelector('.modal-overlay');
      if (modal) {
        modal.classList.add('hidden');
      }
      if (modalOverlay) {
        modalOverlay.style.display = 'none';
      }
    }

    // Initialize the dashboard
    showSection('dashboard');
  </script>
</body>
</html><?php /**PATH C:\Users\sharo\Downloads\Beacon's\BeaconChildrenCenter-1\resources\views/therapists/therapistsDashboard.blade.php ENDPATH**/ ?>