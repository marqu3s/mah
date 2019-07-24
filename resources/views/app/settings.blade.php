@extends('layouts.app')

@section('content')
<div class="container">
    <user-settings user-id="<?= auth()->user()->id ?>"></user-settings>
</div>
@endsection
