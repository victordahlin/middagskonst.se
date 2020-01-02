<?php 

namespace App\Http\Controllers;

use App\StartPage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return $this
     */
    public function index()
    {
        $products = \App\Products::getDinners();
        $extra = \App\Products::getExtra();
        $startPageText = StartPage::all();

        return view('page.home')
            ->with('products', $products)
            ->with('extraProducts', $extra)
            ->with('startPageText',$startPageText);
    }

    /**
     * Get texts from database and populate
     * pages with content
     * @return  $howItWorksText
     */
    public function howItWorks()
    {
        $howItWorksText = \App\HowItWorks::all();

        return view('page.how-it-works')
            ->with('texts', $howItWorksText);
    }

    /**
     * Get texts from database and populate
     * pages with content
     * @return  $howItWorksText
     */
    public function getConditions()
    {
        $howItWorksText = \App\HowItWorks::all();

        return view('page.conditions')
            ->with('texts', $howItWorksText);
    }

    /**
     * Receive user input and confirm the zip code
     * @return string
     */
    public function validPostalCode()
    {
        return \App\BudbeeOrders::checkPostalCode() ? 'true' : 'false';
    }

    /**
     * Display a listing of bags
     * @return $this
     */
    public function getBags(Request $request)
    {
        $products = \App\Products::getDinners();
        $alternativeBags = \App\Products::getAlternativeBags();
        $storeTitle = 'Melanders';

        $dinnerBags = \App\DinnerBags::all();
        $page = 'page.melanders';

        if($request->is('ulla-winbladh')){
          $page = 'page.ulla-winbladh';
          $storeTitle = 'WinBladhs';
        } else if($request->is('lidingosaluhall')){
          $page = 'page.lidingosaluhall';
          $storeTitle = 'saluhalls';
        }

        $menus = \App\DinnerMenu::orderBy('week')->having('title','LIKE','%'.$storeTitle.'%')->get();

        return view($page)
            ->with('products', $products)
            ->with('menus', $menus)
            ->with('alternativeBags', $alternativeBags)
            ->with('dinnerBags', $dinnerBags);
    }

    /**
     * Display a listing of bags
     * @return mixed
     */
    public function getWeeklyBags()
    {
        $alternativeBags = \App\Products::getAlternativeBags();
        $menus = \App\DinnerMenu::orderBy('order')->get();

        return view('page.weekly-menu')
            ->with('menus', $menus)
            ->with('alternativeBags', $alternativeBags);
    }
}
