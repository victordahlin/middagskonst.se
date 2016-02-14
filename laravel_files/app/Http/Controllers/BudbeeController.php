<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BudbeeController extends Controller
{
    private $client;

    /**
     * Default constructor and init variables.
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->client = \App\BudbeeOrders::getClient();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        \App\BudbeeOrders::createOrder($this->client);

    }

    public function test200(){
        \App\BudbeeOrders::testBudbee200($this->client);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show()
    {
        \App\BudbeeOrders::show($this->client);
    }

}
