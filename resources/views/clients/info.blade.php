<style>
    .circular--square { border-radius: 50%; }
    .circular--portrait { position: relative; width: 200px; height: 200px; overflow: hidden; border-radius: 50%; } 
    .circular--portrait img { width: 100%; height: auto; }

</style>
<div class="card-box">
    @if($client->passport)
    <img src="{{passport($client->passport)}}" alt="" class="circular--square img-thumbnail" style="max-width: 60px;">
    @else
    <div style="margin-right: 0;
                display: inline-block;
                height: 60px;
                width: 60px;
                background: #2889ce;
                border-radius: 100px;
                line-height: 60px;
                color: #fff;
                text-align: center;
                font-size: 20px;
                box-shadow: 0 3px 5px rgba(0, 0.5, 0, 0.31);">
        <div>{{ strtoupper(@$client->first_name[0].@$client->last_name[0])  }}</div>
    </div>
    @endif
    
    <div class="mt-2">
        <table class="table table-bordered table-nowrap mb-0">
            <thead>
                <tr>
                    <th colspan="2">Information</th>
                </tr>
            </thead>
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
        <hr>
        <h6>Cases</h6>
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