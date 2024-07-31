<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        return response()->json(["users"=>User::all()],200);
    }

    // Display the specified resource.
    public function show($id)
    {
        return response()->json(["users"=>User::findOrFail($id)],200) ;
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
             'role' => 'required|string|in:user,admin'
        ]);

        return User::create($validated);
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
             'email' => 'sometimes|string|email|max:255' ,
             'password' => 'sometimes|string|min:8',
        ]);

        $user->update($validated);

        return $user;
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $post = User::findOrFail($id);
        $post->delete();

        return response()->noContent();
    }
    public function bulkImport(Request $request)
    {
        // Validate if the file is present
        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
            ]);
        } catch (\Exception $e) {
          //  Log::error('Validation error: ' . $e->getMessage());
            return response()->json(['message' => 'Validation error'], 422);
        }
    
        $file = $request->file('file');
        
        // Print file details for debugging
      //  Log::info('Uploaded file details: ' . $file->getClientOriginalName());
    
        try {
            $data = $this->parseFile($file);
    
            // Print the parsed data for debugging
            //Log::info('Parsed data: ' . print_r($data, true));
        } catch (\Exception $e) {
           // Log::error('File parsing error: ' . $e->getMessage());
            return response()->json(['message' => 'File parsing error'], 500);
        }
    
        // Validate the incoming data
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'role' => 'required|string|in:user,admin',
            ]);
    
            if ($validator->fails()) {
                // Print validation errors for debugging
                //Log::error('Validation failed: ' . print_r($validator->errors()->toArray(), true));
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
        }
    
        // Import users into the database
        foreach ($data as $row) {
            try {
                User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => Hash::make($row['password']),
                    'role' => $row['role'],
                ]);
            } catch (\Exception $e) {
                // Print any errors during user creation for debugging
                //Log::error('User creation failed: ' . $e->getMessage() . ' Data: ' . print_r($row, true));
                return response()->json(['message' => 'User creation failed'], 500);
            }
        }
    
        return response()->json(['message' => 'Users imported successfully']);
    }
    

    

    private function parseFile($file)
    {
        $extension = $file->getClientOriginalExtension();
        $data = [];

        if ($extension === 'csv') {
            $file = fopen($file->getRealPath(), 'r');
            $header = fgetcsv($file); // Skip header row
            while (($row = fgetcsv($file)) !== false) {
                $data[] = array_combine($header, $row);
            }
            fclose($file);
        } else {
            // Handle Excel file (xlsx, xls)
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $header = $sheet->rangeToArray('A1:D1')[0]; // Assuming first row is header
            foreach ($sheet->toArray() as $index => $row) {
                if ($index === 0) continue; // Skip header row
                $data[] = array_combine($header, $row);
            }
        }

        return $data;
    }
   
}
