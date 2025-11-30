<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
class MemberApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Member::all()
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'data' => Member::findOrFail($id)
        ]);
    }

    public function store(Request $request)
    {
        // ADD VALIDATION HERE
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:members',
            'phone' => 'required|string',
            'address' => 'nullable|string',
        ]);

        $member = Member::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Member created',
            'data' => $member
        ], 201);
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'sometimes|required|string',
        'email' => 'sometimes|required|email|unique:members,email,' . $id,
        'phone' => 'sometimes|required|string',
        'address' => 'sometimes|nullable|string',
    ]);

    $member = Member::findOrFail($id);
    $member->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Member updated'
    ], 200);  // 
}


    public function destroy($id)
    {
        Member::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Member deleted'
        ]);
    }
}
