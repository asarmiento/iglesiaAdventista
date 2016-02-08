<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 07/02/16
 * Time: 08:00 PM
 */

namespace SistemasAmigables\Http\Controllers;


use SistemasAmigables\Repositories\BankRepository;

class BankController extends Controller
{
    /**
     * @var BankRepository
     */
    private $bankRepository;

    public function __construct(
        BankRepository $bankRepository
    )
    {

        $this->bankRepository = $bankRepository;
    }

    public function index()
    {
        $banks = $this->bankRepository->allData();
        return view('banks.index',compact('banks'));
    }
}