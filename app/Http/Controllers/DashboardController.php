<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Request;

class DashboardController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $dinnerMenu = \App\DinnerMenu::all();

		return view('page.dashboard')
            ->with('dinnerMenu', $dinnerMenu);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $starterFirst = Request::input('starter1');
        $mainFirst = Request::input('main1');
        $dessertFirst = Request::input('dessert1');
        $firstWeek = Request::input('week1');

        $starterSecond = Request::input('starter3');
        $mainSecond = Request::input('main3');
        $dessertSecond = Request::input('dessert3');
        $secondWeek = Request::input('week2');

        $starterThird = Request::input('starter3');
        $mainThird = Request::input('main3');
        $dessertThird = Request::input('dessert3');
        $thirdWeek = Request::input('week3');

        $firstFridayBag = \App\DinnerMenu::find(1);
        $secondFridayBag = \App\DinnerMenu::find(3);
        $thirdFridayBag = \App\DinnerMenu::find(5);

        // Fishbags
        $fishBag = \App\DinnerMenu::find(2);
        $fishBag2 = \App\DinnerMenu::find(4);
        $fishBag3 = \App\DinnerMenu::find(6);


        /* Friday bag with id 1 */
        if(!empty($starterFirst)){
            $firstFridayBag->starter = $starterFirst;
        }

        if(!empty($mainFirst)){
            $firstFridayBag->main = $mainFirst;
        }

        if(!empty($dessertFirst)){
            $firstFridayBag->dessert = $dessertFirst;
        }

        if(!empty($firstWeek)){
            $firstFridayBag->week = $firstWeek;
            $fishBag->week = $firstWeek;
            $fishBag->save();
        }

        /* Friday bag with id 3 */
        if(!empty($starterSecond)){
            $secondFridayBag->starter = $starterSecond;
        }

        if(!empty($mainSecond)){
            $secondFridayBag->main = $mainSecond;
        }

        if(!empty($dessertSecond)){
            $secondFridayBag->dessert = $dessertSecond;
        }

        if(!empty($secondWeek)){
            $secondWeek->week = $secondWeek;
            $fishBag2->week = $secondWeek;
            $fishBag2->save();
        }

        /* Friday bag with id 5 */
        if(!empty($starterThird)){
            $thirdFridayBag->starter = $starterThird;
        }

        if(!empty($mainThird)){
            $thirdFridayBag->main = $mainThird;
        }

        if(!empty($dessertThird)){
            $thirdFridayBag->dessert = $dessertThird;
        }

        if(!empty($thirdWeek)){
            $thirdFridayBag->week = $thirdWeek;
            $fishBag3->week = $thirdWeek;
            $fishBag3->save();
        }

        // Saving bags
        $firstFridayBag->save();
        $secondFridayBag->save();
        $thirdFridayBag->save();

        return back();

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
