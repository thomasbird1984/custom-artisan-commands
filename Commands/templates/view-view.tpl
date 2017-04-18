@extends('layouts.two-column')

@section('content-main')

<table class="table table-striped">
    <thead>
    <tr>
        <th></th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @if( ${{namePlural}}->count() )
    @foreach(${{namePlural}} as ${{nameLower}})
    <tr>
        <td>{{ ${{nameLower}}-> }}</td>
        <td>
            <a href="{{ route('{{namePlural}}_single', ['id' => ${{nameLower}}->id]) }}">View</a>
            <a class="prompt" href="{{ route('{{namePlural}}_delete', ['id' => ${{nameLower}}->id]) }}">Delete</a>
        </td>
    </tr>
    @endforeach
    @else
    <tr>
        <td colspan="6">No {{namePlural}} found...</td>
    </tr>
    @endif
    </tbody>
</table>

{{ ${{namePlural}}->links() }}

@stop

@section('sidebar-primary')

{{ Form::open(['route' => '{{namePlural}}_add', 'method' => 'post']) }}

<div class="form-group">
    {!! Form::label('',':') !!}
    {!! Form::text('', null, ['class' => 'form-control']) !!}
</div>

<button type="submit" class="btn btn-primary">Add {{nameLower}}</button>

{{ Form::close() }}

@stop