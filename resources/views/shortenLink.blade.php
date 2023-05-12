<!DOCTYPE html>
<html>
<head>
    <title> Laravel - Create URL shortener </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"/>
</head>
<body>

<div class="container">
    <h1> Laravel - Create URL shortener </h1>

    <div class="card">
        <div class="card-header">
            @if($errors->any())
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            @endif
            <form method="POST" action="{{ route('generate.shorten.link.post') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="link" class="form-control col-11" placeholder="Enter URL"
                           aria-describedby="basic-addon2">
                    <input type="text" name="limit" class="form-control col-1" placeholder="Limit"
                           aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">Generate Shorten Link</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">

            @if (Session::has('message'))
                <div class="alert alert-{{session('message')['type']}}">
                    <p>{{ session('message')['text'] }}</p>
                </div>
            @endif

            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Short Link</th>
                    <th>Limit</th>
                    <th>Total Click</th>
                    <th>Link</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shortLinks as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td><a href="{{ route('shorten.link', $row->code) }}"
                               target="{{ $row->limit === 0 ?'_self':'_blank' }}">{{ route('shorten.link', $row->code) }}</a>
                        </td>
                        <td>{{ $row->limit??'-' }}</td>
                        <td>{{ $row->click_count??'-' }}</td>
                        <td class="text-break">{{ $row->link }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>
