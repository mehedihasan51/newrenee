<?php

namespace App\Http\Controllers\Web\Backend;


use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Helpers\Helper;
use App\Models\SocialLink;
use App\Http\Controllers\Controller;
use App\Models\Commitment;
use Exception;
use Illuminate\Http\JsonResponse;
class CommitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = commitment::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    if ($data->image) {
                        $url = asset($data->image);
                        return '<img src="' . $url . '" alt="image" width="50px" height="50px" style="margin-left:20px;">';
                    } else {
                        return '<img src="' . asset('default/logo.svg') . '" alt="image" width="50px" height="50px" style="margin-left:20px;">';
                    }
                })
                ->addColumn('status', function ($data) {
                    $backgroundColor = $data->status == "active" ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $data->status == "active" ? '26px' : '2px';
                    $sliderStyles = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $status = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

                                <a href="#" type="button" onclick="event.preventDefault(); goToEdit(' . $data->id . ')" class="btn btn-primary fs-14 text-white delete-icn" title="Edit">
                                    <i class="fe fe-edit"></i>
                                </a>

                                <a href="#" type="button" onclick="event.preventDefault(); showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                                
                            </div>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make();
        }
        return view("backend.layouts.commitment.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.layouts.commitment.create');
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
{
    $validate = $request->validate([
        'title' => 'nullable|string|max:50',
        'sub_title' => 'nullable|string|max:50',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    ]);

    try {
        if ($request->hasFile('image')) {
            $validate['image'] = Helper::fileUpload(
                $request->file('image'),
                'image',
                time() . '_' . getFileName($request->file('image'))
            );
        }

        Commitment::create($validate);

        session()->put('t-success', 'commitment created successfully');
    } catch (Exception $e) {
        session()->put('t-error', $e->getMessage());
    }

    return redirect()->route('admin.commitment.index')->with('success', 'commitment created successfully');
}

    /**
     * Display the specified resource.
     */

    public function show(Commitment $commitment, $id)
    {
        $commitment = Commitment::findOrFail($id);
        $commitment->image_url = asset('/' . $commitment->image);

        return view('backend.layouts.commitment.edit',compact('commitment'));
        // return response()->json($commitment);
    }
    // public function show(Category $category, $id)
    // {
    //     $category = $this->categoryRepository->find($id);
    //     return view('backend.layouts.category.edit', compact('category'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commitment $leader, $id)
    {
        $commitment = Commitment::findOrFail($id);
        return view('backend.layouts.commitment.edit', compact('commitment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'title' => 'nullable|string|max:50',
            'sub_title' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        try {
            $commitment = Commitment::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($commitment->image && file_exists(public_path($commitment->image))) {
                    Helper::fileDelete(public_path($commitment->image));
                }
                $validate['image'] = Helper::fileUpload($request->file('image'), 'image', time() . '_' . getFileName($request->file('image')));
            }

            $commitment->update($validate);
            session()->put('t-success', 'commitment updated successfully');
        } catch (Exception $e) {
            session()->put('t-error', $e->getMessage());
        }

        return redirect()->route('admin.commitment.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Commitment::findOrFail($id);
            if ($data->image && file_exists(public_path($data->image))) {
                Helper::fileDelete(public_path($data->image));
            }
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'commitment deleted successfully!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting leader: ' . $e->getMessage()
            ]);
        }
    }

    public function status(int $id): JsonResponse
    {
        $data = Commitment::findOrFail($id);
        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found.',
            ]);
        }
        $data->status = $data->status === 'active' ? 'inactive' : 'active';
        $data->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully!',
        ]);
    }
}
