<?php

namespace App\Http\Controllers;

use App\Jobs\SendInquiryConfirmation;
use App\Jobs\SendInquiryReceived;
use Aws\S3\S3Client;
use App\Models\Inquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\OrderInquiryRequest;

class InquiryController extends Controller
{
    public function processInquirySubmission(OrderInquiryRequest $request): JsonResponse
    {   
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $inquiry = Inquiry::create([
                'email' => $validated['email'],
                'city' => $validated['city'],
                'additional_notes' => $validated['additional_notes'] ?? null,
            ]);
            
            // Create items and upload photos
            foreach ($validated['items'] as $itemData) {
                // Create Item record in db
                $item = $inquiry->items()->create([
                    'details' => $itemData['details'],
                ]);

                // Upload photos if present
                if (isset($itemData['photos']) && !empty($itemData['photos'])) {
                    try {
                        $photoUrls = $this->storeImagesToS3(
                            photos: $itemData['photos'],
                            inquiryId: $inquiry->id,
                            itemId: $item->id,
                        );

                        // Create Photo record in db
                        foreach ($photoUrls as $photoData) {
                            $item->photos()->create($photoData);
                        }
                    } catch (\Aws\S3\Exception\S3Exception $e) {
                        Log::error('S3 upload failed', [
                            'inquiry_id' => $inquiry->id,
                            'item_id' => $item->id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            } 

            DB::commit();
            $inquiry->load('items.photos');
            dispatch(new SendInquiryConfirmation($inquiry));
            dispatch(new SendInquiryReceived());

            return response()->json([
                'message' => 'Inquiry submitted successfully.',
                'inquiry_id' => $inquiry->id,
                'items_count' => $inquiry->items()->count(),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Inquiry submission failed', [
                'email' => $validated['email'] ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Failed to submit inquiry. Please try again later.',
            ], 500);
        } 
    }

    private function storeImagesToS3(array $photos, int $inquiryId, string $itemId): array 
    {
        $s3client = new S3Client([
            'version' => 'latest',
            'region' => config('services.aws.region'),
            'credentials' => [
                'key' => config('services.aws.key'),
                'secret' => config('services.aws.secret'),
            ],
        ]);

        $uploadedPhotos = [];

        foreach ($photos as $photo) {
            $filename = uniqid() . '.' . $photo->extension();
            $key = "inquiries/{$inquiryId}/items/{$itemId}/$filename";

            $s3client->putObject([
                'Bucket' => config('services.aws.bucket'),
                'Key' => $key,
                'Body' => fopen($photo->getRealPath(), 'r'),
                'ContentType' => $photo->getMimeType(),
            ]);

            $url = $s3client->getObjectUrl(
                config('services.aws.bucket'),
                $key
            );

            $uploadedPhotos[] = [
                's3_key' => $key,
                's3_url' => $url,
                'original_filename' => $photo->getClientOriginalName(),
                'file_size' => $photo->getSize(), //bytes
            ];
        }

        return $uploadedPhotos;
    }
}
