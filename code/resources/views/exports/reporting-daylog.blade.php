<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>User Report: {{ $user->name }}</h2>
    <p>Email: {{ $user->email }}</p>
    <p>Division: {{ $user->division->name ?? '-' }}</p>
    <p>Category: {{ $user->category->name ?? '-' }}</p>
    <hr>
    <h3>Absences</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absences as $absen)
            <tr>
                <td>{{ $absen->date }}</td>
                <td>{{ $absen->status ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h3>Logbooks</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Activity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logbooks as $logbook)
            <tr>
                <td>{{ $logbook->date }}</td>
                <td>{{ $logbook->activity ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h3>Pengajuans</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuans as $pengajuan)
            <tr>
                <td>{{ $pengajuan->created_at }}</td>
                <td>{{ $pengajuan->type ?? '-' }}</td>
                <td>{{ $pengajuan->status ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
