<?php

namespace App\Http\Controllers;

use App\Models\RatingGuideQuestion;
use App\Models\JobPoster;
use App\Models\Lookup\AssessmentType;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RatingGuideQuestionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request Incoming request.
     * @throws \InvalidArgumentException For missing $question.
     * @return mixed
     */
    public function store(Request $request)
    {
        try {
            $job_poster_id = (int)$request->json('job_poster_id');
            $assessment_type_id = (int)$request->json('assessment_type_id');
            $question = $request->json('question');

            JobPoster::findOrFail($job_poster_id);
            AssessmentType::findOrFail($assessment_type_id);

            if (empty($question)) {
                throw new \InvalidArgumentException('Question is required.');
            }
            $ratingGuideQuestion = new RatingGuideQuestion([
                'job_poster_id' => $job_poster_id,
                'assessment_type_id' => $assessment_type_id,
                'question' => $question,
            ]);
            $ratingGuideQuestion->save();
            $ratingGuideQuestion->refresh();
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }

        return [
            'success' => "Successfully created rating guide question $ratingGuideQuestion->id"
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RatingGuideQuestion $ratingGuideQuestion Incoming object.
     * @return mixed
     */
    public function show(RatingGuideQuestion $ratingGuideQuestion)
    {
        $ratingGuideQuestion->load([
            'job_poster',
            'assessment_type'
        ]);
        return $ratingGuideQuestion->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request        $request             Incoming request.
     * @param  \App\Models\RatingGuideQuestion $ratingGuideQuestion Incoming object.
     * @throws \InvalidArgumentException For missing $question.
     * @return mixed
     */
    public function update(Request $request, RatingGuideQuestion $ratingGuideQuestion)
    {
        try {
            $job_poster_id = (int)$request->json('job_poster_id');
            $assessment_type_id = (int)$request->json('assessment_type_id');
            $question = $request->json('question');

            JobPoster::findOrFail($job_poster_id);
            AssessmentType::findOrFail($assessment_type_id);

            if (empty($question)) {
                throw new \InvalidArgumentException('Question is required.');
            }

            $ratingGuideQuestion->job_poster_id = $job_poster_id;
            $ratingGuideQuestion->assessment_type_id = $assessment_type_id;
            $ratingGuideQuestion->question = $question;
            $ratingGuideQuestion->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }

        return [
            'success' => "Successfully updated rating guide question $ratingGuideQuestion->id"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RatingGuideQuestion $ratingGuideQuestion Incoming object.
     * @return mixed
     */
    public function destroy(RatingGuideQuestion $ratingGuideQuestion)
    {
        $ratingGuideQuestion->delete();

        return [
            'success' => "Successfully deleted rating guide question $ratingGuideQuestion->id"
        ];
    }
}
