<?php

namespace App\Http\Controllers;

use App\Models\DoctorSpecialization;
use App\Models\visits;
use App\Models\PaymentMode;
use App\Models\User;
use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VisitController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'child_id' => 'required|exists:children,id',
            'visit_type' => 'required|integer',
            'visit_date' => 'required|date',
            'source_type' => 'required|string',
            'source_contact' => 'required|string|max:15',
            'staff_id' => 'required|integer|exists:staff,id',
            'doctor_id' => 'required|integer|exists:staff,id',
            'appointment_id' => 'nullable|integer',
            'payment_mode_id' => 'required|integer|exists:payment_modes,id',
            'triage_pass' => 'required|boolean',
        ]);

        try {
            $visit = Visit::create([
                ...$validatedData,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Visit created successfully',
                'data' => $visit
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error creating visit: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create visit'
            ], 500);
        }
    }

    public function doctorNotes(Request $request)
    {
        $validatedData = $request->validate([
            'child_id' => 'required|exists:children,id',
            'notes' => 'nullable|string'
        ]);

        try {
            $latestVisit = Visits::where('child_id', $validatedData['child_id'])
                ->latest()
                ->firstOrFail();
                //auth()-> id(39)
            if ($latestVisit->doctor_id !==39) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Not authorized: Only the assigned doctor can update these notes'
                ], 403);
            }

            $formattedNotes = "Therapy Session plan and activities:\nSpeech and sound production: " . $validatedData['notes'];

            $latestVisit->update([
                'notes' => $formattedNotes,
                'completed' => true
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Notes updated successfully and visit marked as completed'
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No visit found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error updating doctor notes: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update notes'
            ], 500);
        }
    }

    public function getDoctorNotes($registrationNumber)
    {
        try {
            $child = Child::where('registration_number', $registrationNumber)
                ->firstOrFail();

            $fullname = json_decode($child->fullname);
            $childName = trim(sprintf(
                "%s %s %s",
                $fullname->first_name ?? '',
                $fullname->middle_name ?? '',
                $fullname->last_name ?? ''
            ));

            $visits = Visit::with('doctor')
                ->where('child_id', $child->id)
                ->orderBy('visit_date', 'desc')
                ->get();

            $formattedVisits = $visits->map(function($visit) {
                $doctorName = $this->formatDoctorName($visit->doctor->fullname);
                
                return [
                    'visit_date' => $visit->visit_date,
                    'notes' => $visit->notes ?? 'No notes recorded',
                    'doctor_name' => $doctorName,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => [
                    'registration_number' => $child->registration_number,
                    'child_name' => $childName,
                    'visits' => $formattedVisits
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Child not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error in getDoctorNotes: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve doctor notes'
            ], 500);
        }
    }

    private function formatDoctorName($doctorNameJson)
    {
        try {
            $doctorData = json_decode($doctorNameJson, true);
            
            if (!is_array($doctorData)) {
                return $doctorNameJson;
            }

            if (count($doctorData) === 1 && !is_array(reset($doctorData))) {
                return reset($doctorData);
            }

            $nameParts = [];
            $keys = ['firstname', 'middlename', 'lastname', 'first_name', 'middle_name', 'last_name'];
            
            foreach ($keys as $key) {
                if (!empty($doctorData[$key])) {
                    $nameParts[] = $doctorData[$key];
                }
            }

            return !empty($nameParts) ? implode(' ', $nameParts) : $doctorNameJson;

        } catch (\Exception $e) {
            return $doctorNameJson;
        }
    }

    public function getSpecializations()
    {
        try {
            $specializations = DoctorSpecialization::select('id', 'specialization')
                ->distinct()
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $specializations
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching specializations: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch specializations'
            ], 500);
        }
    }

    public function getDoctorsBySpecialization(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'specialization_id' => 'required|exists:doctor_specialization,specialization_id'
            ]);

            $doctors = User::where('specialization_id', $validatedData['specialization_id'])
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $doctors
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching doctors: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch doctors'
            ], 500);
        }
    }

    public function showSpecializations()
    {
        $specializations = DoctorSpecialization::select('specialization_id', 'specialization')
            ->distinct()
            ->get();
            
        return view('Receiptionist/visit', compact('specializations'));
    }

    public function specializationSearch(Request $request)
    {
        $validated = $request->validate([
            'specialization_id' => 'required|exists:doctor_specialization,specialization_id',
        ]);

        $staffIds = DoctorSpecialization::where('specialization_id', $validated['specialization_id'])
            ->pluck('staff_id');

        return redirect()->route('staff.fetch', ['staff_ids' => $staffIds->toArray()]);
    }
}