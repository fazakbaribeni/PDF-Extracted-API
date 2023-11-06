<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TextractControllerTest extends TestCase
{

    /**
     * @return void
     */
    public function testProcessPdf()
    {
        // Provide the path to the real PDF file
        $pdfPath = public_path('pdf/pdf-test.pdf');

        try {
            $response = $this->json('POST', 'http://127.0.0.1:8000/api/extract-text', [
                'pdf' => new UploadedFile($pdfPath, 'pdf-test.pdf'),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Text extracted and stored successfully',
            ]);


        // Additional assertions can be added based on your requirements
    }
}
