<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machine;
use App\Helpers\MachineIdGenerator;
class GenerateMachineID extends Controller
{
    public function generateMachineID(Request $request)
    {
        $prefix = 'CSM-';

        // Get the current year
        $currentYear = date('Y');

        // Get the last machine ID from the database
        $lastMachine = Machine::latest()->first();

        // Extract the numeric part and increment it
        $lastNumber = $lastMachine ? intval(substr($lastMachine->formattedId, strlen($prefix) + 4)) : 0;
        $newNumber = $lastNumber + 1;

        // Generate the formatted machine ID
        $formattedId = $prefix . $currentYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // Create a new machine record in the database
        $machineId = Machine::create([
            'formattedId' => $formattedId,
            // other fields if any
        ]);

        return response()->json([
            'machineId' => $machineId->formattedId,
        ]);
    }

    public function fetchMachineID($user_id)
    {
        $machineId = Machine::all();
        
        if ($machineId) {
            return response()->json(['machineId' => $machineId]);
        } else {
            return response()->json(['message' => 'machine id not found']);
        }
    }

}
