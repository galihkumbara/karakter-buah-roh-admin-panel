<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Helpers\ResponseHelper;
use Exception;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $contents = Content::all();
            return ResponseHelper::success($contents);
        } catch (Exception $e) {
            return ResponseHelper::error(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $content = Content::findOrFail($id);
            return ResponseHelper::success($content);
        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error('Content not found', 404);
        } catch (Exception $e) {
            return ResponseHelper::error(['message' => $e->getMessage()], 500);
        }
    }
}
