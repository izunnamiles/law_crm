@extends('index')
@section('content')
<div class="d-flex justify-content-end">
    <form class="d-flex" role="search">
        <input class="form-control me-2" name="q" minlength="2" "search" placeholder="Search Client" aria-label="Search">
        <button class="btn btn-sm btn-outline-secondary" type="submit">search</button>
    </form>
</div>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">S/N</th>
            <th scope="col">Name</th>
            <th scope="col">Email </th>
            <th scope="col">Date Profiled</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($clients as $key => $client)
        <tr>
            <th scope="row">{{$key+1}}</th>
            <td>{{$client->first_name.' '.$client->last_name}}</td>
            <td>{{$client->email}}</td>
            <td>{{$client->date_profiled}}</td>
            <td>
                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modalButton" href="#exampleModal" data-title="{{$client->first_name.' '.$client->last_name}}" data-view="{{ route('client-info', ['id' => $client->id]) }}" data-params="0" data-type="wide">
                    View Profile
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No client found</td>
        </tr>
        @endforelse
    </tbody>
</table>

<script type="text/javascript">
    if (!sh)
        var sh = window.sh = {};

    sh.showModal = function(obj, title, view, size) {
        $('#exampleModal .modal-title').text(title);
        $('.modal-dialog').removeClass('modal').removeClass('modal-md').addClass(size);

        $.get(view, function(response) {
            $('#exampleModal .modal-body').html(response);
        });
    }


    $(document).ready(function() {
        $('.modal-header .close');
        $('body').on('click', '#modalButton', function() {
            size = 'modal-md';
            sh.showModal($(this), $(this).attr('data-title'), $(this).attr('data-view'), size);
        });

        $('#viewModal').on('hidden.bs.modal', function() {
            $('#exampleModal .modal-title').text("Default Text");
            $('#exampleModal .modal-body').html(window.preloader);
        });
    });
</script>
@endsection