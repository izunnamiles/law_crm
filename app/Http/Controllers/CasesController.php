<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCaseRequest;
use App\Models\Counsel;
use App\Notifications\WelcomeNotification;
use App\Repositories\CasesRepository;
use App\Repositories\ClientRepository;
use Illuminate\Support\Facades\Notification;

class CasesController extends Controller
{
    public function __construct(
        private CasesRepository $casesRepository,
        private ClientRepository $clientRepository
    ) {
    }
    public function add()
    {
        $counsels = Counsel::pluck('name','id');
        return view('cases.form', compact('counsels'));
    }
    public function create(CreateCaseRequest $request)
    {
        $sendMail = false;
        if ($request->client_type == 'new') {
            if ($request->hasFile('passport')){
                $passport = passportUpload($request->passport);
            }
            $client = $this->clientRepository->create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'passport' => $passport ?? null,
                'date_of_birth' => $request->date_of_birth,
                'date_profiled' => $request->date_profiled,
            ]);
            $sendMail = true;
        }else {
            $client = $this->clientRepository->find($request->client_id);
        }
        $caseNo = 'LFX' . now()->timestamp;
        $this->casesRepository->create([
            'case_no' => $caseNo,
            'case_details' => $request->case_details,
            'counsel_id' => $request->counsel,
            'client_id' => $client->id,
        ]);

        if ($sendMail){
            Notification::route('mail', $client->email)->notify(new WelcomeNotification($client));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'case added successfully'
        ]);
    }
}
