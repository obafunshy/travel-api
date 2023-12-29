<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Travel;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\TravelRequest;
use App\Http\Resources\TravelResource;
use Illuminate\Auth\AuthenticationException;

class TravelController extends Controller
{
    public function store(TravelRequest $request) {
        Log::info('Attempting to store travel data.');
        if (!auth()->check()) {
            Log::info('User is not authenticated.');
            throw new AuthenticationException('Unauthenticated.');
        }

        $travel = Travel::create($request->validated());
        return new TravelResource($travel);
    }
}
