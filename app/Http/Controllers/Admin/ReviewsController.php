<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bracelet;
use App\Models\Review;
use App\Http\Requests\Admin\ReviewRequest;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::paginate(30);
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bracelets = Bracelet::pluck('name', 'id')->all();

        return view('admin.reviews.create', compact('bracelets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request)
    {
        
        Review::create([
            'bracelet_id' => request('bracelet_id'),
            'name' => request('name'),
            'email' => request('email'),
            'review_text' => request('review_text'),
            'rating_user' => request('rating_user'),
            'period_use' => request('period_use')
        ]);

        $allrating = (json_decode(Review::where([['rating_user','>', 0],['bracelet_id', '=', request('bracelet_id')]])->pluck('rating_user')));
        $sumVotes = array_sum ($allrating);
        $totalVotes = count($allrating);
        $votesRange = [1, 2, 3, 4, 5];

        $z = 1.64485;
        $vMin = min($votesRange);
        $vWidth = floatval(max($votesRange) - $vMin);

        $phat = ($sumVotes - $totalVotes * $vMin) / $vWidth / floatval($totalVotes);

        $rating = ($phat + $z * $z / (2 * $totalVotes) - $z * sqrt(($phat * (1 - $phat) + $z * $z / (4 * $totalVotes)) / $totalVotes)) / (1 + $z * $z / $totalVotes);

        $endRating = round($rating * $vWidth + $vMin, 6);

        $bracelet = Bracelet::where('id', request('bracelet_id'))->first();
        $bracelet->rating_bracelet = $endRating;
        $bracelet->save();


        return redirect()->route('reviews.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = Review::find($id);

        $bracelets = Bracelet::pluck('name', 'id')->all();

        $braceletreview = Bracelet::where('id', $review->bracelet_id)->select('name')->first();
        
        return view('admin.reviews.edit', compact('review', 'bracelets', 'braceletreview'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewRequest $request, $id)
    {
        $review = Review::find($id);

        $review->update([
            'bracelet_id' => request('bracelet_id'),
            'name' => request('name'),
            'email' => request('email'),
            'review_text' => request('review_text'),
            'rating_user' => request('rating_user'),
            'period_use' => request('period_use')
        ]);

        $allrating = (json_decode(Review::where([['rating_user','>', 0],['bracelet_id', '=', request('bracelet_id')]])->pluck('rating_user')));
        $sumVotes = array_sum ($allrating);
        $totalVotes = count($allrating);
        $votesRange = [1, 2, 3, 4, 5];

        $z = 1.64485;
        $vMin = min($votesRange);
        $vWidth = floatval(max($votesRange) - $vMin);

        $phat = ($sumVotes - $totalVotes * $vMin) / $vWidth / floatval($totalVotes);

        $rating = ($phat + $z * $z / (2 * $totalVotes) - $z * sqrt(($phat * (1 - $phat) + $z * $z / (4 * $totalVotes)) / $totalVotes)) / (1 + $z * $z / $totalVotes);

        $endRating = round($rating * $vWidth + $vMin, 6);

        $bracelet = Bracelet::where('id', request('bracelet_id'))->first();
        $bracelet->rating_bracelet = $endRating;
        $bracelet->save();

        return redirect()->route('reviews.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $brand = Brand::find($id);
        // $brand->delete();
        Review::destroy($id);
        
        return redirect()->route('reviews.index');
    }

}
