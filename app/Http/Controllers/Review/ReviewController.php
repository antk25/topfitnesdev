<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bracelet;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, Bracelet $bracelet)
    {

        $bracelet->reviews()->create([
            'name' => request('name'),
            'email' => request('email'),
            'review_text' => request('review_text'),
            'rating_user' => request('rating_user'),
            'period_use' => request('period_use')
        ]);



        $allrating = (json_decode(Review::where([['rating_user','>', 0],['bracelet_id', '=', $bracelet->id]])->pluck('rating_user')));
        $sumVotes = array_sum ($allrating);
        $totalVotes = count($allrating);
        $votesRange = [1, 2, 3, 4, 5];

        $z = 1.64485;
        $vMin = min($votesRange);
        $vWidth = floatval(max($votesRange) - $vMin);

        $phat = ($sumVotes - $totalVotes * $vMin) / $vWidth / floatval($totalVotes);

        $rating = ($phat + $z * $z / (2 * $totalVotes) - $z * sqrt(($phat * (1 - $phat) + $z * $z / (4 * $totalVotes)) / $totalVotes)) / (1 + $z * $z / $totalVotes);

        $endRating = round($rating * $vWidth + $vMin, 6);

        $bracelet = Bracelet::where('id', $bracelet->id)->first();
        $bracelet->rating_bracelet = $endRating;
        $bracelet->save();

        return back();
    }



    public function index(Request $request, Bracelet $bracelet)
    {
        $reviews = Review::where('bracelet_id', $bracelet->id)->orderBy('id', 'desc')->limit(5)->get();

        // if ($request->expectsJson()) {
        //     return response()->json($reviews->toArray());
        // }

        return view('comments.index', compact('reviews'));
    }
}
