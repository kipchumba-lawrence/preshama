<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class systemupdate extends Controller
{
    public function fetchCategories()
    {
        $url = 'http://api.sajsoft.co.ke:96/api/categories/categories.php';

        // Perform the API request using Laravel's HTTP client
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer YOUR_AUTH_TOKEN_HERE' // Add your authorization token if needed
        ])->get($url);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch categories'], 500);
        }

        $data = $response->json();

        // Using DB transactions to ensure data integrity
        DB::transaction(function () use ($data) {
            foreach ($data as $row) {
                $material_group_code = $row['id'];
                $material_group_name = $row['category'];

                if (!empty($material_group_code)) {
                    // Call the stored procedure using DB::statement
                    DB::statement('CALL sp_material_group_insert(:p_material_group_code, :p_material_group_name)', [
                        'p_material_group_code' => $material_group_code,
                        'p_material_group_name' => $material_group_name,
                    ]);
                }
            }
        });

        return response()->json(['message' => 'Material groups fetched and inserted successfully']);
    }
}
