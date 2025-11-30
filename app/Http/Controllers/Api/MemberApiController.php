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
        // hanya admin (karena sudah dilindungi di route)
        $member = Member::create($request->all());

        return response()->json([
            'message' => 'Member created',
            'data' => $member
        ]);
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->update($request->all());

        return response()->json([
            'message' => 'Member updated'
        ]);
    }

    public function destroy($id)
    {
        Member::destroy($id);

        return response()->json([
            'message' => 'Member deleted'
        ]);
    }
}

