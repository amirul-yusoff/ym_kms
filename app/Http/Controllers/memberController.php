<?php

namespace App\Http\Controllers;
use App\Http\Models\Member;
use App\Http\Models\notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;

class memberController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$member = Member::find($id);
        if($member->id != Auth::user()->id) {
            return redirect()->back();
        }
    	return view('members.view', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$data = Member::find($id);
        if($data->id != Auth::user()->id) {
            return redirect()->back();
        }
        return view('members.members', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, []);

        $input = $request->all();
        $member = Member::find($id);
        $member->update($input);


        return redirect('member/'.$id)->with('success', 'Profile updated');
    }

    /**
     * Reset password for the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetPassword($id)
    {
        $data = Member::find($id);
        if($data->id != Auth::user()->id) {
            return redirect()->back();
        }
        return view('members.password', compact('data'));
    }

    /**
     * Set new password for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setPassword(Request $request, $id)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $input = $request->all();
        if(Hash::check($input['current_password'], Auth::user()->password)) {
            Member::where('id', $id)->update([
                'password' => Hash::make($input['password'])
            ]);
            return redirect('member/'.$id)->with('success', 'Password changed');
        }
        return redirect()->back()->withErrors('You had entered the wrong current password. Please try again.');
    }

    /**
     * Read and update all notification has read.
     */
    public function readNoti()
    {
        $noti = notification::where('receiver_code', Auth::user()->employee_code)->get();
        foreach($noti as $n) {
            $n->update([
                'has_read' => 1
            ]);
        }
        return ['success' => true];
    }
}
