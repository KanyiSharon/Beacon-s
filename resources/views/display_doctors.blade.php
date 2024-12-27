<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors List</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');

        body {
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 24px;
        }

        .search-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .search-bar {
            flex-grow: 1;
            margin-right: 16px;
        }

        .search-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .table-wrapper {
            max-height: 300px; /* Reduced height for a smaller display area */
            overflow-x: auto;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            white-space: nowrap;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        th {
            color: #666;
            font-weight: 500;
            background-color: #f9f9f9;
        }

        td {
            color: #555;
        }

        .specialization {
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 14px;
            display: inline-block;
        }

        .cardiology {
            background-color: #e8f0fe;
            color: #1a73e8;
        }

        .neurology {
            background-color: #ffe8ec;
            color: #e91e63;
        }

        .calendar-icon {
            font-size: 18px;
            color: #0066cc;
            cursor: pointer;
        }

        .no-results {
            text-align: center;
            color: #777;
            font-style: italic;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Doctors List</h1>
        
        <div class="search-container">
            <div class="search-bar">
                <input type="text" 
                       class="search-input" 
                       placeholder="Search doctors by name, ID, or specialization..."
                       onkeyup="searchDoctors(this.value)">
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Role</th>
                        <th>Specialisation</th>
                        <th>Staff ID</th>
                        <th>Calendar</th>
                    </tr>
                </thead>
                <tbody id="doctorsTable">
                    @foreach ($doctors as $doctor)
                    <tr class="doctor-row">
                        <td>{{ $doctor->id }}</td>
                        <td>{{ $doctor->staff->fullname}}</td>
                        <td>{{ $doctor->staff->telephone }}</td>
                        <td>{{ $doctor->staff->email }}</td>
                        <td>{{ $doctor->staff->gender_id }}</td>
                        <td>{{ $doctor->staff->role_id }}</td>
                        <td>
                            <span class="specialization {{ strtolower($doctor->specialization) }}">{{ $doctor->specialization }}</span>
                        </td>
                        <td>{{ $doctor->staff_id }}</td>
                        <td>
                            <span class="calendar-icon">📅</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="no-results" id="noResults" style="display: none;">
            No doctors found.
        </div>
    </div>

    <script>
        function searchDoctors(query) {
            query = query.toLowerCase();
            const rows = document.querySelectorAll('.doctor-row');
            let found = false;

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                    found = true;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('noResults').style.display = found ? 'none' : 'block';
        }
    </script>
</body>
</html>
