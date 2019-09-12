@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">User List >> Task List</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                @foreach ($users as $user)
                                    <td>
                                        <p>{{ $user['first_name'] }} {{ $user['last_name'] }}</p>
                                        {!!  App\Helpers\TaskHelper::taskList($user['tasks']) !!}

                                    </td>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
