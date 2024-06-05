<?php

namespace App\Http\Controllers;

use App\Models\DemandeMentorat;
use Illuminate\Http\Request;

class DemandeMentoratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showForm()
     {
         return view('mentorat.demande');
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DemandeMentorat $demandeMentorat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DemandeMentorat $demandeMentorat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DemandeMentorat $demandeMentorat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DemandeMentorat $demandeMentorat)
    {
        //
    }
}
