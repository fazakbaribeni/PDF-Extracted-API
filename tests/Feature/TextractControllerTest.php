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
        Storage::fake('public'); // Use 'public' disk for file uploads

        $pdf = UploadedFile::fake()->create('test.pdf', 1024); // Create a fake PDF file

        $response = $this->json('POST', '/api/extract-text', [
            'pdf' => $pdf,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Text extracted and stored successfully',
            ]);

        // Additional assertions can be added based on your requirements
    }
}
