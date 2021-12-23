<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bracelet;
use App\Models\Review;
use App\Http\Requests\Admin\ReviewRequest;

class ReviewController extends Controller
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
        $bracelets = Bracelet::get();

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
        $pst = $request->item_id;

        $pst = explode(",", $pst);

        Review::create([
            'reviewable_type' => $pst[1],
            'reviewable_id' => $pst[0],
            'name' => request('name'),
            'email' => request('email'),
            'review_text' => request('review_text'),
            'rating_user' => request('rating_user'),
            'period_use' => request('period_use')
        ]);

//        $allrating = (json_decode(Review::where([['rating_user','>', 0],['reviewable_id', '=', $pst[2]],['reviewable_type', '=', $pst[1]]])->pluck('rating_user')));
//        $sumVotes = array_sum($allrating);
//        $totalVotes = count($allrating);
//        $votesRange = [1, 2, 3, 4, 5];
//
//        $z = 1.64485;
//        $vMin = min($votesRange);
//        $vWidth = floatval(max($votesRange) - $vMin);
//
//        $phat = ($sumVotes - $totalVotes * $vMin) / $vWidth / floatval($totalVotes);
//
//        $rating = ($phat + $z * $z / (2 * $totalVotes) - $z * sqrt(($phat * (1 - $phat) + $z * $z / (4 * $totalVotes)) / $totalVotes)) / (1 + $z * $z / $totalVotes);
//
//        $endRating = round($rating * $vWidth + $vMin, 6);
//
//
//        $this->model->rating_bracelet = $endRating;
//
//        $this->model->save();
//
//        $this->model->refresh();


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

        $braceletreview = Bracelet::where('id', $review->bracelet_id)->select('name')->first();

        return view('admin.reviews.edit', compact('review', 'braceletreview'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewRequest $request, int $id)
    {
        $review = Review::find($id);

        $result = $review->update([
            'bracelet_id' => request('bracelet_id'),
            'name' => request('name'),
            'email' => request('email'),
            'review_text' => request('review_text'),
            'rating_user' => request('rating_user'),
            'period_use' => request('period_use')
        ]);

//        $allrating = (json_decode(Review::where([['rating_user','>', 0],['bracelet_id', '=', request('bracelet_id')]])->pluck('rating_user')));
//        $sumVotes = array_sum ($allrating);
//        $totalVotes = count($allrating);
//        $votesRange = [1, 2, 3, 4, 5];
//
//        $z = 1.64485;
//        $vMin = min($votesRange);
//        $vWidth = floatval(max($votesRange) - $vMin);
//
//        $phat = ($sumVotes - $totalVotes * $vMin) / $vWidth / floatval($totalVotes);
//
//        $rating = ($phat + $z * $z / (2 * $totalVotes) - $z * sqrt(($phat * (1 - $phat) + $z * $z / (4 * $totalVotes)) / $totalVotes)) / (1 + $z * $z / $totalVotes);
//
//        $endRating = round($rating * $vWidth + $vMin, 6);
//
//        $bracelet = Bracelet::where('id', request('bracelet_id'))->first();
//        $bracelet->rating_bracelet = $endRating;
//        $bracelet->save();

        if ($result) {
            return redirect()
                ->back()
                ->with(['success' => 'Сохранено. Отредактируйте данные, если нужно']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения, проверьте все поля, где подсвечена ошибка'])
                ->withInput();
        }

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
