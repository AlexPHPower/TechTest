@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">First</th>
                        <th scope="col">Initial</th>
                        <th scope="col">Last</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($people as $person)
                        <tr>
                            <td>{{ $person['title'] }}</td>
                            <td>{{ $person['first_name'] }}</td>
                            <td>{{ $person['initial'] }}</td>
                            <td>{{ $person['last_name'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
