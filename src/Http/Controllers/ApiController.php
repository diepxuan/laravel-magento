<?php

declare(strict_types=1);

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 *
 * © Tran Ngoc Duc <ductn@diepxuan.com>
 *   Tran Ngoc Duc <caothu91@gmail.com>
 */

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Api;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/api/index', [
            'apis' => Api::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/api/new');
    }

    public function getToken()
    {
        return redirect()->route('admin.api.index');
    }

    public function token(Request $request, $type)
    {
        $api       = new Api();
        $api->type = $type;
        $api       = $api->castAs();

        return $api->new($request);

        return redirect()->route('admin.api.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void {}

    /**
     * Display the specified resource.
     */
    public function show(Api $api): void {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Api $api): void {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Api $api)
    {
        if ($request->input('renew', 0)) {
            try {
                $api = $api->castAs();
                $api->renew($request);
            } catch (\Throwable $th) {
                // throw $th;
                return redirect()->route('admin.api.index');
            }
        }

        return redirect()->route('admin.api.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Api $api)
    {
        $api->delete();

        return redirect()->route('admin.api.index');
    }
}
