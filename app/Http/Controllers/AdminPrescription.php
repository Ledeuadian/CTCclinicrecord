<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrescriptionRecord;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminPrescription extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $prescriptions = PrescriptionRecord::all();
        return view('admin.prescription.index', compact('prescriptions'));
    }

    /**
     * Export prescriptions data to CSV
     */
    public function export()
    {
        $prescriptions = PrescriptionRecord::join('users', 'users.id', '=', 'prescription_records.patient_id')
            ->leftJoin('medicines', 'medicines.id', '=', 'prescription_records.medicine_id')
            ->select(
                'prescription_records.id',
                'users.name as patient_name',
                'users.email',
                'medicines.name as medicine_name',
                'prescription_records.dosage',
                'prescription_records.frequency',
                'prescription_records.duration',
                'prescription_records.instruction',
                'prescription_records.status',
                'prescription_records.date_prescribed',
                'prescription_records.date_discontinued',
                'prescription_records.discontinuation_reason',
                'prescription_records.created_at'
            )
            ->get();

        $csvContent = "ID,Patient Name,Patient Email,Medicine Name,Dosage,Frequency,Duration,Instructions,Status,Date Prescribed,Date Discontinued,Discontinuation Reason,Created At\n";

        foreach ($prescriptions as $prescription) {
            $csvContent .= sprintf(
                "%d,\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",%s,%s,\"%s\",%s\n",
                $prescription->id,
                str_replace('"', '""', $prescription->patient_name ?? ''),
                str_replace('"', '""', $prescription->email ?? ''),
                str_replace('"', '""', $prescription->medicine_name ?? ''),
                str_replace('"', '""', $prescription->dosage ?? ''),
                str_replace('"', '""', $prescription->frequency ?? ''),
                str_replace('"', '""', $prescription->duration ?? ''),
                str_replace('"', '""', $prescription->instruction ?? ''),
                str_replace('"', '""', $prescription->status ?? ''),
                $prescription->date_prescribed ?? '',
                $prescription->date_discontinued ?? '',
                str_replace('"', '""', $prescription->discontinuation_reason ?? ''),
                $prescription->created_at ?? ''
            );
        }

        // Add BOM for Excel UTF-8 compatibility
        $csvContent = "\xEF\xBB\xBF" . $csvContent;

        return response($csvContent, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="prescriptions.csv"',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $users = User::all();
        return view('admin.prescription.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Show the form for editing a prescription with type
     */
    public function updateWithType($id)
    {
        $prescription = PrescriptionRecord::findOrFail($id);
        $patients = \App\Models\Patients::all();
        $doctors = \App\Models\Doctors::all();
        $medicines = \App\Models\Medicine::all();
        return view('admin.prescription.edit', compact('prescription', 'patients', 'doctors', 'medicines'));
    }

    /**
     * Delete a prescription with type
     */
    public function deleteWithType($id)
    {
        $prescription = PrescriptionRecord::findOrFail($id);
        $prescription->delete();
        return redirect()->route('admin.prescription.index')->with('success', 'Prescription deleted successfully');
    }
}
