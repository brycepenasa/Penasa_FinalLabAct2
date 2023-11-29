<style>
    .container {
        margin: 20px;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #ffffff;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <div class="container">
            <h1>Hello.... {{ auth()->user()->name }}</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Register Date</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if (\Carbon\Carbon::parse($user->created_at)->diffInSeconds() < 60)
                                    {{ \Carbon\Carbon::parse($user->created_at)->diffInSeconds() }} seconds
                                @elseif (\Carbon\Carbon::parse($user->created_at)->diffInMinutes() < 60)
                                    {{ \Carbon\Carbon::parse($user->created_at)->diffInMinutes() }} minutes
                                @else
                                    {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}
                                @endif
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="3">Total User: {{ $i }}</td>
                       
                    </tr>
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>
