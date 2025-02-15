<!DOCTYPE html>
<html>
<head>
    <title>Receiptionist Dashboard</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, sans-serif;
            background-color: #fff;
        }

        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #111827;
            overflow: visible;  /* Changed to visible to show hover content */
            padding-top: 20px;
            color: white;
            transition: width 0.3s ease;
            z-index: 100;
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

        .sidebar a {
            padding: 12px 20px;
            text-decoration: none;
            font-size: 14px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
        }

        .sidebar.collapsed a {
            padding: 12px;
            justify-content: center;
            width: 60px;
        }

        .sidebar.collapsed a:hover {
            width: auto;
            background-color: #1f2937;
            padding-right: 20px;
        }

        .sidebar.collapsed a span.icon {
            margin-right: 0;
            transition: margin 0.3s ease;
        }

        .sidebar.collapsed a:hover span.icon {
            margin-right: 12px;
        }

        .sidebar.collapsed a span.text {
            display: none;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .sidebar.collapsed a:hover span.text {
            display: inline;
            opacity: 1;
        }

        .sidebar a:hover {
            background-color: #1f2937;
        }

        .sidebar img {
            width: 40px;
            height: 40px;
            margin: 0 auto 20px;
            display: block;
        }

        .main {
            margin-left: 200px;
            padding: 40px;
            background-color: #f3f4f6;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main.expanded {
            margin-left: 60px;
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .search-input {
            padding: 8px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            width: 300px;
            background-color: #fff;
        }

        .add-button {
            background-color: #e2e8f0;
            color: #1f2937;
            padding: 8px 16px;
            border-radius: 20px;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-button:hover {
            background-color: #cbd5e1;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        th {
            background-color: #f8fafc;
            padding: 16px;
            text-align: left;
            font-weight: 500;
            color: #64748b;
            font-size: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            color: #1f2937;
        }

        .specialty-badge {
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 12px;
            display: inline-block;
        }

        .specialty-cardiology {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .specialty-neurology {
            background-color: #fce7f3;
            color: #9d174d;
        }

        .page-title {
            font-size: 24px;
            color: #111827;
            margin-bottom: 24px;
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="Logo">
    <a href="#"><span class="icon">➕</span> <span class="text">Add Patient</span></a>
    <a href="#"><span class="icon">👥</span> <span class="text">Parents</span></a>
    <a href="#"><span class="icon">📅</span> <span class="text">Appointments</span></a>
    <a href="#"><span class="icon">🕒</span> <span class="text">Visit</span></a>
    <a href="<?php echo e(route('doctors')); ?>"><span class="icon">👨‍⚕️</span> <span class="text">Doctors</span></a>
    <a href="#"><span class="icon">💰</span> <span class="text">Payments</span></a>
    <a href="#"><span class="icon">👥</span> <span class="text">Staff</span></a>
</div>

<div class="toggle-button" id="toggle-button" onclick="toggleSidebar()"></div>

<div class="main" id="main">
    <h1 class="page-title">Doctor's Details</h1>
    
    <div class="search-bar">
        <input type="text" placeholder="Search Doctor Name" class="search-input">
        <form action="<?php echo e(route('doctor.form')); ?>" method="GET">
            <button type="submit" class="add-button">
                <span>+</span>
                Add Doctor
            </button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Specialisation</th>
                <th>Staff ID</th>
                <th>Calendar</th>
            </tr>
        </thead>
        <tbody id="progressTableBody">
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td><span class="specialty-badge specialty-cardiology">Cardiology</span></td>
                <td>1</td>
                <td>📅</td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td><span class="specialty-badge specialty-neurology">Neurology</span></td>
                <td>1</td>
                <td>📅</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    // Sidebar toggle 
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('.main');
        const toggleButton = document.getElementById('toggle-button');
        
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('expanded');
        toggleButton.classList.toggle('collapsed');
    }

    document.getElementById('therapyNeedsForm')?.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('/therapist/save', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData,
        })
            .then(response => response.json())
            .then(data => alert(data.message))
            .catch(error => console.error('Error:', error));
    });

    function loadProgress() {
        fetch('/therapist/progress')
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('progressTableBody');
                tbody.innerHTML = '';
                data.forEach(progress => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${progress.date}</td>
                        <td>${progress.sessionDetails}</td>
                        <td>${progress.progressNotes}</td>
                        <td><button>Edit</button></td>
                    `;
                    tbody.appendChild(row);
                });
            });
    }

    loadProgress();
</script>

</body>
</html><?php /**PATH C:\Users\giftg\beaconfolder\BeaconChildrenCenter\resources\views/Receiptionist\Receiptionist_dashboard.blade.php ENDPATH**/ ?>