<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>


</head>

<body class="font-sans antialiased">
    <h2>Pending Repairs</h2>

    <p>Good morning Team,</p>

    <p>Reminder of all <strong>pending repairs</strong> awaiting attention.</p>

    <p>Please check if any of trucks is in the yard or expected soon and lets work on them.
    </p>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Truck</th>
                <th>Fault</th>
                <th>Status</th>
                <th>Location</th>
                <th>
                    Last Reported At
                </th>
                <th>
                    Last Checked At
                </th>
                <th class="p-2 border font-medium border-r text-[13px] border-gray-300">
                    Created By
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($repairs as $repair)
                <tr>
                    <td>{{ $repair->truck->unitname ?? 'N/A' }}</td>
                    <td>{{ $repair->fault->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($repair->status) }}</td>
                    <td>{{ $repair->location }}</td>
                    <td>
                        {{ $repair->last_reported_at }}

                    </td>
                    <td>

                        {{ $repair->last_check_at }}
                    </td>
                    <td>
                        {{ $repair->user->name }}

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

  <p>Thank you for your commitment and professionalism.</p>

    <p>Regards,<br>
    Maintenance & Repairs Team</p>
    <p>Committed to Excellence
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
            <line x1="9" y1="9" x2="9.01" y2="9"></line>
            <line x1="15" y1="9" x2="15.01" y2="9"></line>
            <path d="M16 5a2 2 0 0 0-4 0"></path>
        </svg>
    </p>

</body>

</html>
