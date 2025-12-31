<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderInquiryRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class InquiryController extends Controller
{
    public function processInquirySubmission(OrderInquiryRequest $request): JsonResponse
    {   
        $validated = $request->validated();

        // Resend::emails()->send([
        //     'from' => 'onboarding@resend.dev',
        //     'to' => 'alfreychan@gmail.com',
        //     'subject' => 'Resend Test',
        //     'html' => '<h1>Resend Test</h1>',
        // ]);

        return response()->json([
            'message' => "Sent by " . $validated['email'],
        ], 200);
    }
}
