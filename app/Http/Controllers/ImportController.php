<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Medicine;
use App\Models\Patients;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    /**
     * Show import selection page
     */
    public function index()
    {
        return view('admin.import.index');
    }

    /**
     * Show import form for users
     */
    public function users()
    {
        return view('admin.import.users');
    }

    /**
     * Show import form for medicines
     */
    public function medicines()
    {
        return view('admin.import.medicines');
    }

    /**
     * Process user import with column mapping
     */
    public function processUsers(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls',
            'name_column' => 'required|integer',
            'email_column' => 'required|integer',
            'password_column' => 'nullable|integer',
            'user_type_column' => 'nullable|integer',
        ]);

        $file = $request->file('file');
        $data = Excel::toArray([], $file);

        if (empty($data) || empty($data[0])) {
            return back()->with('error', 'The uploaded file is empty or invalid.');
        }

        $rows = $data[0];
        $headers = array_map('trim', $rows[0]);
        $dataRows = array_slice($rows, 1);

        $nameCol = $request->name_column;
        $emailCol = $request->email_column;
        $passwordCol = $request->password_column;
        $userTypeCol = $request->user_type_column;

        $imported = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($dataRows as $index => $row) {
                if (empty(array_filter($row))) continue;

                $name = isset($row[$nameCol]) ? trim($row[$nameCol]) : null;
                $email = isset($row[$emailCol]) ? trim($row[$emailCol]) : null;
                $password = isset($row[$passwordCol]) && !empty($row[$passwordCol]) ? trim($row[$passwordCol]) : 'password123';
                $userType = isset($row[$userTypeCol]) && !empty($row[$userTypeCol]) ? (int)$row[$userTypeCol] : 2; // Default to patient

                if (empty($name) || empty($email)) {
                    $errors[] = "Row " . ($index + 2) . ": Name and Email are required.";
                    continue;
                }

                // Check if email already exists
                if (User::where('email', $email)->exists()) {
                    $errors[] = "Row " . ($index + 2) . ": Email '$email' already exists. Skipped.";
                    continue;
                }

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'user_type' => $userType,
                ]);

                // If user type is patient (2), create patient record
                if ($userType == 2) {
                    Patients::create([
                        'user_id' => $user->id,
                    ]);
                }

                $imported++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }

        $message = "Successfully imported $imported users.";
        if (!empty($errors)) {
            $message .= " " . count($errors) . " rows skipped due to errors.";
        }

        $redirect = auth()->user()->user_type == 0 ? 'admin.medicines.index' : 'staff.dashboard';
        return redirect()->route($redirect)->with('success', $message);
    }

    /**
     * Process medicine import with column mapping
     */
    public function processMedicines(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls',
            'name_column' => 'required|integer',
            'description_column' => 'nullable|integer',
            'quantity_column' => 'nullable|integer',
            'expiration_date_column' => 'nullable|integer',
            'medicine_type_column' => 'nullable|integer',
        ]);

        $file = $request->file('file');
        $data = Excel::toArray([], $file);

        if (empty($data) || empty($data[0])) {
            return back()->with('error', 'The uploaded file is empty or invalid.');
        }

        $rows = $data[0];
        $dataRows = array_slice($rows, 1);

        $nameCol = $request->name_column;
        $descCol = $request->description_column;
        $qtyCol = $request->quantity_column;
        $expCol = $request->expiration_date_column;
        $typeCol = $request->medicine_type_column;

        $imported = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($dataRows as $index => $row) {
                if (empty(array_filter($row))) continue;

                $name = isset($row[$nameCol]) ? trim($row[$nameCol]) : null;

                if (empty($name)) {
                    $errors[] = "Row " . ($index + 2) . ": Medicine name is required.";
                    continue;
                }

                // Check if medicine with same name already exists
                if (Medicine::where('name', $name)->exists()) {
                    // Update existing medicine quantity
                    $medicine = Medicine::where('name', $name)->first();
                    if ($qtyCol !== null && isset($row[$qtyCol]) && is_numeric($row[$qtyCol])) {
                        $medicine->quantity += (int)$row[$qtyCol];
                        $medicine->save();
                    }
                    $imported++;
                    continue;
                }

                $medicineData = [
                    'name' => $name,
                    'description' => ($descCol !== null && isset($row[$descCol])) ? trim($row[$descCol]) : '',
                    'quantity' => ($qtyCol !== null && isset($row[$qtyCol]) && is_numeric($row[$qtyCol])) ? (int)$row[$qtyCol] : 0,
                    'expiration_date' => ($expCol !== null && isset($row[$expCol]) && !empty($row[$expCol])) ? date('Y-m-d', strtotime($row[$expCol])) : null,
                    'medicine_type' => ($typeCol !== null && isset($row[$typeCol])) ? trim($row[$typeCol]) : 'General',
                ];

                Medicine::create($medicineData);
                $imported++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }

        $message = "Successfully imported $imported medicines.";
        if (!empty($errors)) {
            $message .= " " . count($errors) . " rows skipped due to errors.";
        }

        $redirect = auth()->user()->user_type == 0 ? 'admin.medicines.index' : 'staff.dashboard';
        return redirect()->route($redirect)->with('success', $message);
    }

    /**
     * Generate sample CSV for users
     */
    public function downloadUsersSample()
    {
        $headers = ['name', 'email', 'password', 'user_type'];
        $sampleData = [
            ['Juan Dela Cruz', 'juan.delacruz@example.com', 'password123', '2'],
            ['Maria Santos', 'maria.santos@example.com', 'password123', '2'],
        ];

        $content = "name,email,password,user_type\n";
        foreach ($sampleData as $row) {
            $content .= implode(',', $row) . "\n";
        }

        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users_sample.csv"',
        ]);
    }

    /**
     * Generate sample CSV for medicines
     */
    public function downloadMedicinesSample()
    {
        $content = "name,description,quantity,expiration_date,medicine_type\n";
        $content .= "Paracetamol 500mg,For headache and mild pain,100,2026-12-31,General\n";
        $content .= "Amoxicillin 250mg,Antibiotic for infections,50,2026-06-30,Antibiotic\n";

        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="medicines_sample.csv"',
        ]);
    }
}
