<?php

namespace App\Http\Controllers;

use App\Models\ApplicationReview;
use App\Models\JobApplication;
use App\Models\Lookup\ReviewStatus;
use App\Models\Lookup\ReviewDecision;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplicationReviewController extends Controller
{
    /**
     * Update the review for the specified application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobApplication  $application
     * @return \Illuminate\Http\Response
     */
    public function updateForApplication(Request $request, JobApplication $application)
    {
        $request->validate([
            'review_status' => [
                'required',
                Rule::in(ReviewStatus::all()->pluck('id')->toArray())
            ],
            'review_decision' => [
                'required',
                Rule::in(ReviewDecision::all()->pluck('id')->toArray())
            ],
            'reviewer' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $review = $application->application_review;
        if ($review === null) {
            $review = new ApplicationReview();
            $review->job_application()->associate($application);
        }
        $review->fill([
            'review_status_id' => $request->input('review_status'),
            'review_decision_id' => $request->input('review_decision'),
            'reviewer' => $request->input('reviewer'),
            'notes' => $request->input('notes'),
        ]);
        $review->save();

        if($request->ajax()) {
            return $review->toJson();
        }

        return redirect()->back();
    }
}