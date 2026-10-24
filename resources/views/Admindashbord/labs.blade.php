@extends('layouts.auth')

@section('title','Laboratories')

@section('content')
<h1>Laboratories & Devices</h1>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

@foreach($labs as $lab)
    <section style="border:1px solid #ddd;padding:12px;margin-bottom:12px">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <h3>{{ $lab->block_name }} ({{ $lab->block_code }})</h3>
            <a href="{{ route('admin.labs.edit', $lab->block_code) }}">Edit lab</a>
        </div>
        <p>Capacity: {{ $lab->capacity }}</p>

        <table border="1" cellpadding="6" cellspacing="0" style="width:100%">
            <thead>
                <tr><th>Reg No</th><th>Name</th><th>Brand</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @foreach($lab->device as $device)
                <tr>
                    <td>{{ $device->reg_no }}</td>
                    <td>{{ $device->device_name }}</td>
                    <td>{{ $device->brand }}</td>
                    <td>
                        <a href="{{ route('admin.devices.edit', $device->id) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endforeach

@endsection
