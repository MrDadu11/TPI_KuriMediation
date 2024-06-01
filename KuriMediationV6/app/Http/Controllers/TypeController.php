<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
    /**
     * 
     * Controller for types
     * 
     * **/

    // Function that displays the list of types page
    public function index(){
        $types = Type::all();

        return view('types', [
            'types' => $types,
        ]);
    }

    // Function that creates a new type
    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Type::create([
            'name' => $validatedData['name'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back();
    }


    // Function that redirects to the editing page based on the type id
    public function edit($typeId){
        $currentType = Type::find($typeId);
        return view('types.edit_types', [
            'currentType' => $currentType
        ]);
    }
    
    // Function that updates the name of the type based on its id
    public function update(Request $request, $typeId){
        $currentType = Type::find($typeId);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $currentType->update($validatedData);

        return redirect()->route('type.index');
    }

    // Function that deletes the type based on its id
    public function destroy($typeId){
        $meeting = Meeting::where('type_id', $typeId)->exists();

        if($meeting){
            return redirect()->route('type.index')->with('error', 'Il y a encore des entretiens ayant ce type attibué. Veuillez les supprimer avant');
        }else{
            Type::destroy($typeId);
            return redirect()->back();
        }
    }


}
