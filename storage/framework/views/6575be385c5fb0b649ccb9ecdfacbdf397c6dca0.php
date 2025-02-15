<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor's Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel=stylesheet href="<?php echo e(asset ('css/doctorDash.css')); ?>">
 
</head>
<body>

  <header>
  <div class="profile">
  <i class="fas fa-user-md fa-4x"></i> <div>
    <h2 style="margin-bottom: 6px;">Dr. <?php echo e($firstName); ?> <?php echo e($lastName); ?></h2>
    <p style="margin-top:0">Pediatrician</p>
  </div>
</div>
    <div class="notifications">
    <div class="clock" id="clock"></div> 
      <div class="dropdown">
        <button class="dropbtn"><i class="fas fa-user"></i></button>
        <div class="dropdown-content">
          <a href="#"  id="dropdown-profile-link">View Profile</a>
          <a href="#">Settings</a>
          <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>

          <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
          </form>
        </div>
      </div>
    </div>
  </header>

  <main>
    <aside class="sidebar">
      <nav>
        <ul>
          <li class="active"><a href="#" id="dashboard-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
          <li><a href="#" id="profile-link"><i class="fas fa-user"></i> Profile</a></li>
          <li><a href="#" id="booked-link"><i class="fas fa-book"></i> Booked Patients</a></li> 
          <li><a href="#" id="therapist-link"><i class="fas fa-user-md"></i> Therapy </a></li> 
        </ul>
      </nav>
    </aside>

    <section class="dashboard" id="dashboard-content">
      <div class="welcome">
      <h3 id="greeting"></h3>
      </div>
      <div class="patient-queue">
        <h2>Patients Waiting</h2>
        <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr>
               
                <!-- <th>Patient Name</th> -->
                
            </tr>
        </thead>
        <tbody id="post-triage-list">
            <tr>
                <td colspan="6" style="text-align: center;">Loading...</td>
            </tr>
        </tbody>
    </table>
        <ul id="patient-list"></ul>
      </div>
      <div class="actions">
        <!-- <button class="start-consult">Start Consultation</button> -->
        <!-- <button class="view-schedule">View Schedule</button> -->
      </div>
    </section>

    <section class="profile-content" id="profile-content" style="display: none;">
      <h2>Doctor's Profile</h2>
      <p>This is where you would display the doctor's profile information.</p>
    </section>

    <section class="content" id="booked-content" style="display: none;">
      <h2>Booked Patients</h2>
      <p>This is where you would display the booked patients list.</p>
    </section>

    <section class="content" id="therapist-content" style="display: none;">
      <h2>Therapy List</h2>
      <p>This is where you would display the therapy list.</p>
    </section>
  </main>

  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
  <script src="<?php echo e(asset ('js/doctorDash.js')); ?>"></script>
  <script>
    function updateClock() {
      const now = new Date();
      const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
      document.getElementById('clock').textContent = timeString;
    }
    setInterval(updateClock, 1000);
    function updateGreeting() {
      const now = new Date();
      const hours = now.getHours();
      let greeting = "Good morning"; // Default to morning
      if (hours >= 12 && hours < 18) {
        greeting = "Good afternoon";
      } else if (hours >= 18) {
        greeting = "Good evening";
      }
      document.getElementById('greeting').textContent = `${greeting}, Dr. <?php echo e($lastName); ?>!`;
    }
    updateGreeting(); 
    setInterval(updateGreeting, 60 * 60 * 1000);
  </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/doctorDash.blade.php ENDPATH**/ ?>