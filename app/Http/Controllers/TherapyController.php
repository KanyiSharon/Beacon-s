<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 

class TherapyController extends Controller
{
    public function show($registrationNumber)
     {
        $child = DB::table('children')
                    ->where('registration_number', $registrationNumber)
                    ->first();

        if (!$child) {
            abort(404);
        }

        // Decode the fullname JSON
        $fullname = json_decode($child->fullname);

        // Access the first_name, middle_name, and last_name
        $firstName = $fullname->first_name;
        $middleName = $fullname->middle_name;
        $lastName = $fullname->last_name;

        // Get the gender name from the gender table
        $gender = DB::table('gender')->where('id', $child->gender_id)->value('gender');

        // Fetch triage data for the child
        $triage = DB::table('triage')->where('child_id', $child->id)->first();

        if ($triage) {
            // Decode the triage data JSON
            $triageData = json_decode($triage->data);

            // Access the individual data points
            $temperature = $triageData->temperature;
            $weight = $triageData->weight;
            // $height = $triageData->height;
            // $head_circumference = $triageData->head_circumference;
            // $blood_pressure = $triageData->blood_pressure;
            // $pulse_rate = $triageData->pulse_rate;
            // $respiratory_rate = $triageData->respiratory_rate;
            // $oxygen_saturation = $triageData->oxygen_saturation;
            // $MUAC = $triageData->MUAC; 

            // Pass the decoded triage data to the view
            return view('therapists.occupationaltherapyDashboard', [
                'child' => $child,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'lastName' => $lastName,
                'gender' => $gender,
                // 'triage' => $triage,
                // 'temperature' => $temperature,
                // 'weight' => $weight,
                // 'height' => $height,
                // 'head_circumference' => $head_circumference,
                // 'blood_pressure' => $blood_pressure,
                // 'pulse_rate' => $pulse_rate,
                // 'respiratory_rate' => $respiratory_rate,
                // 'oxygen_saturation' => $oxygen_saturation,
                // 'MUAC' => $MUAC
            ]);
        } else {
            // Handle case where no triage data is found
            return view('doctor', [
                'child' => $child,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'lastName' => $lastName,
                'gender' => $gender,
                'triage' => null, 
            ]);
        }
    }
    
    //fix this later for the doctors notes in therapy
    public function getChildDetails($registrationNumber)
{
    try {
        // Retrieve child by registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();
        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }

        // Decode the fullname JSON
        $fullname = json_decode($child->fullname);
        $firstName = $fullname->first_name ?? null;
        $middleName = $fullname->middle_name ?? null;
        $lastName = $fullname->last_name ?? null;

        // Get gender name
        $gender = DB::table('gender')->where('id', $child->gender_id)->value('gender');

        // Retrieve the latest visit for the child
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->latest()
            ->first();

        // Check if a visit exists
        if (!$visit) {
            return response()->json(['error' => 'No visit found for the child'], 404);
        }

        // Fetch triage data
        $triage = DB::table('triage')->where('child_id', $child->id)->first();
        $triageData = $triage ? json_decode($triage->data) : null;

        // Fetch CNS data
        $cnsData = DB::table('cns')
            ->where('child_id', $child->id)
            ->latest()
            ->first();
        $cnsData = $cnsData ? json_decode($cnsData->data) : null;
        
        $perinatalHistory = DB::table('perinatal_history')
            ->where('child_id', $child->id)
            ->latest()
            ->first();
        $perinatalHistory = $perinatalHistory ? json_decode($perinatalHistory->data) : null;

        // Fetch developmental milestones
        $milestones = DB::table('development_milestones')
            ->where('child_id', $child->id)
            ->latest()
            ->first();
        $milestonesData = $milestones ? json_decode($milestones->data) : null;
        
        $pastMedicalHistory = DB::table('past_medical_history')
        ->where('child_id', $child->id)
        ->latest()
        ->first();
    $pastMedicalHistory = $pastMedicalHistory ? json_decode($pastMedicalHistory->data) : null;
    
    $BehaviourAssessment = DB::table('behaviour_assessment')
        ->where('child_id', $child->id)
        ->latest()
        ->first();
    $BehaviourAssessment = $BehaviourAssessment ? json_decode($BehaviourAssessment->data) : null;
    
    $FamilySocialHistory = DB::table('family_social_history')
        ->where('child_id', $child->id)
        ->latest()
        ->first();
    $FamilySocialHistory = $FamilySocialHistory ? json_decode($FamilySocialHistory->data) : null;


        // Pass all data to the view
       // Prepare the data for the textarea
$doctorsNotes = "";
$doctorsNotes .= $triageData ? "Triage Data:\n" . json_encode($triageData, JSON_PRETTY_PRINT) . "\n\n" : "Triage Data: No data available.\n\n";
$doctorsNotes .= $cnsData ? "CNS Data:\n" . json_encode($cnsData, JSON_PRETTY_PRINT) . "\n\n" : "CNS Data: No data available.\n\n";
$doctorsNotes .= $milestonesData ? "Milestones Data:\n" . json_encode($milestonesData, JSON_PRETTY_PRINT) . "\n\n" : "Milestones Data: No data available.\n\n";

$doctorsNotes .= $perinatalHistory ? "perinatalHistory Data:\n" . json_encode($perinatalHistory, JSON_PRETTY_PRINT) . "\n\n" : "perinatalHistory Data: No data available.\n\n";

$doctorsNotes .= $pastMedicalHistory ? "pastMedicalHistory Data:\n" . json_encode($pastMedicalHistory, JSON_PRETTY_PRINT) . "\n\n" : "pastMedicalHistory Data: No data available.\n\n";

$doctorsNotes .= $BehaviourAssessment ? "BehaviourAssessment Data:\n" . json_encode($BehaviourAssessment, JSON_PRETTY_PRINT) . "\n\n" : "BehaviourAssessment Data: No data available.\n\n";

$doctorsNotes .= $FamilySocialHistory ? "FamilySocialHistory Data:\n" . json_encode($FamilySocialHistory, JSON_PRETTY_PRINT) . "\n\n" : "FamilySocialHistory Data: No data available.\n\n";

// Pass the notes to the view
if (request()->wantsJson() || request()->ajax()) {
    return response()->json([
        'child' => $child,
        'child_id' => $child->id,
        'firstName' => $firstName,
        'middleName' => $middleName,
        'lastName' => $lastName,
        'gender' => $gender,
        'doctorsNotes' => $doctorsNotes,
    ]);
}

// Otherwise return the view
return view('therapists.occupationaltherapyDashboard', [
    'child' => $child,
    'child_id' => $child->id,
    'firstName' => $firstName,
    'middleName' => $middleName,
    'lastName' => $lastName,
    'gender' => $gender,
    'doctorsNotes' => $doctorsNotes,
]);

} catch (\Exception $e) {
Log::error("Error in getChildDetails: " . $e->getMessage());
if (request()->wantsJson() || request()->ajax()) {
    return response()->json(['error' => 'Internal server error'], 500);
}
throw $e;
}
}

public function saveTherapyGoal(Request $request)
{
    $validatedData = $request->validate([
        'child_id' => 'required|exists:children,id',
        'staff_id' => 'required|integer|exists:staff,id',
        'therapy_id' => 'required|integer|exists:therapy,id',
        'data' => 'required|array', // Ensures that 'data' is an array
    ]);

    try {
        // Fetch the latest visit_id for the provided child_id
        $latestVisit = DB::table('visits')
            ->where('child_id', $validatedData['child_id'])
            ->latest('id') // Order by 'id' descending
            ->first();

        if (!$latestVisit) {
            return response()->json(['status' => 'error', 'message' => 'No visits found for the provided child_id'], 404);
        }

        // Get the visit_id from the latest visit
        $visitId = $latestVisit->id;

        // Convert the 'data' array into a JSON string
        $jsonData = json_encode($validatedData['data'], JSON_THROW_ON_ERROR);

        // Insert data into the therapy_goals table
        DB::table('therapy_goals')->insert([
            'child_id' => $validatedData['child_id'],
            'staff_id' => $validatedData['staff_id'],
            'therapy_id' => $validatedData['therapy_id'],
            'visit_id' => $visitId, // Use the fetched visit_id
            'data' => $jsonData, // Save the JSON-encoded string
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Therapy goals saved successfully'], 201);
    } catch (\JsonException $jsonException) {
        return response()->json(['status' => 'error', 'message' => 'Invalid JSON data provided'], 400);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
//Assessment handling like pushing to db

public function saveAssessment(Request $request)
{
    $validatedData = $request->validate([
        'child_id' => 'required|exists:children,id',
        'staff_id' => 'required|integer|exists:staff,id',
        'therapy_id' => 'required|integer|exists:therapy,id',
        'data' => 'required|array', // Ensures that 'data' is an array
    ]);

    try {
        // Fetch the latest visit_id for the provided child_id
        $latestVisit = DB::table('visits')
            ->where('child_id', $validatedData['child_id'])
            ->latest('id') // Order by 'id' descending
            ->first();

        if (!$latestVisit) {
            return response()->json(['status' => 'error', 'message' => 'No visits found for the provided child_id'], 404);
        }

        // Save the assessment data
        DB::table('therapy_assesment')->insert([
            'child_id' => $validatedData['child_id'],
            'staff_id' => $validatedData['staff_id'],
            'therapy_id' => $validatedData['therapy_id'],
            'visit_id' => $latestVisit->id,
            'data' => json_encode($validatedData['data']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Assessment saved successfully'], 201);
    } catch (\JsonException $jsonException) {
        return response()->json(['status' => 'error', 'message' => 'Invalid JSON data provided'], 400);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
public function saveIndividualized(Request $request)
{
    $validatedData = $request->validate([
        'child_id' => 'required|exists:children,id',
        'staff_id' => 'required|integer|exists:staff,id',
        'therapy_id' => 'required|integer|exists:therapy,id',
        'data' => 'required|array', // Ensures that 'data' is an array
    ]);

    try {
        // Fetch the latest visit_id for the provided child_id
        $latestVisit = DB::table('visits')
            ->where('child_id', $validatedData['child_id'])
            ->latest('id') // Order by 'id' descending
            ->first();

        if (!$latestVisit) {
            return response()->json(['status' => 'error', 'message' => 'No visits found for the provided child_id'], 404);
        }

        // Save the individualized data
        DB::table('therapy_individualized')->insert([
            'child_id' => $validatedData['child_id'],
            'staff_id' => $validatedData['staff_id'],
            'therapy_id' => $validatedData['therapy_id'],
            'visit_id' => $latestVisit->id,
            'data' => json_encode($validatedData['data']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Individulaized plans and stategies saved successfully'], 201);
    } catch (\JsonException $jsonException) {
        return response()->json(['status' => 'error', 'message' => 'Invalid JSON data provided'], 400);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
}