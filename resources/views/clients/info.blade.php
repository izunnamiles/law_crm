<style>
    .circular--portrait {
        margin-right: 0;
        margin-top: 20px;
        margin-left: 5px;
        display: inline-block;
        height: 200px;
        width: 200px;
        border-radius: 100px;
        line-height: 70px;
    }

    .text-portrait {
        margin-right: 0;
        margin-top: 20px;
        margin-left: 2px;
        display: inline-block;
        height: 200px;
        width: 200px;
        background: #262c27;
        border-radius: 100px;
        line-height: 70px;
        color: #fff;
        text-align: center;
        font-size: 50px;
        box-shadow: 0 3px 5px rgba(0, 0.5, 0, 0.31);
    }

    .circular--portrait img {
        width: 100%;
        height: auto;
    }
</style>
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-3">
            @if($client->passport)
            <img src="{{ passport($client->passport) }}" alt="" class="circular--portrait img-thumbnail">
            @else
            <div class="text-portrait">
                <div style="padding-top: 65px;">{{ strtoupper(@$client->first_name[0].@$client->last_name[0])  }}</div>
            </div>
            @endif
        </div>
        <div class="col-md-9">
            <div class="card-body">
                <h5 class="card-title">Client Information</h5>
                <table class="table table-bordered table-nowrap mb-0">
                    <tbody>
                        <tr>
                            <th class="text-muted">Name</th>
                            <td>{{$client->first_name.' '.$client->last_name}}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Email</th>
                            <td>{{$client->email}}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Date of Birth</th>
                            <td>{{$client->date_of_birth}}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Date Profiled</th>
                            <td>{{$client->date_profiled}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card-box">
    <div class="mt-2">
        <h5> Cases <small> (Last 5 cases) </small></h5>
        <table class="table table-bordered table-nowrap mb-0">
            <thead>
                <tr>
                    <th scope="col">S/N</th>
                    <th scope="col">Case No</th>
                    <th scope="col">Case Details</th>
                    <th scope="col">Principal Counsel</th>
                </tr>
            </thead>
            <tbody>
                @forelse($client->cases as $key => $case)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$case->case_no}}</td>
                    <td>{{$case->case_details}}</td>
                    <td>{{$case->counsel->name}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">No Case Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>