<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\FeedbackModel;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create($id)
    {
        $ticketno = $id;

        return view('feedback.create',compact('ticketno'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stars'=>'required',
            'feedback_description'=>'required'
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $feedback_exist = FeedbackModel::where('ticketno', '=', \Input::get('ticketno'))->exists();

        if ($feedback_exist) {

            return redirect('home')->with('feedback_message_warning', 'feedback for this request is already submitted.');

        }
        else{

            $feedback = new FeedbackModel;

            $feedback->ticketno = $request->ticketno;

            $feedback->stars = $request->stars;

            $feedback->description = $request->feedback_description;

            $feedback->save();

            return redirect('home')->with('feedback_message', 'feedback successfully submitted.');
        }
    }
}
