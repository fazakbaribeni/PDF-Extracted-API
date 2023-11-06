<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Aws\Textract\TextractClient;


class TextractController extends Controller
{
    public function processPdf(Request $request)
    {

        // Validate the request
        try {
            // Validate the request
            $request->validate([
                'pdf' => 'required|file|mimes:pdf',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        // Get the uploaded PDF file
        $pdf = $request->file('pdf');


        // Convert the PDF to base64
        $base64Pdf = base64_encode(file_get_contents($pdf->path()));

        // Initialize AWS Textract client
        $textractClient = new TextractClient([
            'version'     => 'latest',
            'region'      => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    =>  env('AWS_ACCESS_KEY_ID'),
                'secret' =>  env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        // Call AWS Textract to extract text
        $result = $textractClient->detectDocumentText([
            'Document' => [
                'Bytes' => base64_decode($base64Pdf),
            ],
        ]);

        // Extract the text from Textract result
        $extractedText = '';
        foreach ($result['Blocks'] as $block) {
            if ($block['BlockType'] == 'LINE') {
                $extractedText .= $block['Text'] . "\n";
            }
        }

        // Store the extracted text and request time in the database
        DB::table('extracted_texts')->insert([
            'text'       => $extractedText,
            'requested_at' => now(),
        ]);

        return response()->json(['message' => 'Text extracted and stored successfully']);
    }
}
