<?php

namespace App\Http\Controllers\Web\Backend;


use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Helpers\Helper;
use App\Models\SocialLink;
use App\Http\Controllers\Controller;
use App\Models\Executive;
use Exception;
use Illuminate\Http\JsonResponse;
class ExecutiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Executive::all();
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
                                
                                <a href="#" type="button" onclick="event.preventDefault(); viewModalContent(' . $data->id . ')" class="btn btn-green fs-14 text-white delete-icn" title="View">
                                    <i class="fe fe-eye"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make();
        }
        return view("backend.layouts.executive.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.layouts.executive.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $validate = $request->validate([
    //         'name' => 'nullable|string|max:50',
    //         'title' => 'nullable|string|max:50',
    //         'position' => 'nullable|string|max:50',
    //         'button_text' => 'nullable|string|max:50',
    //         'description' => 'nullable|string|max:50',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

    //     ]);

    //     try {

    //         if ($request->hasFile('image')) {
    //             $validate['image'] = Helper::fileUpload($request->file('image'), 'image', time() . '_' . getFileName($request->file('image')));

    //         }
            

    //         Executive::create($validate);

    //         session()->put('t-success', 'Executive created successfully');
    //     } catch (Exception $e) {
    //         session()->put('t-error', $e->getMessage());
    //     }

    //     return redirect()->route('admin.executive.index')->with('success', 'Executive created successfully');
    //     // return redirect()->back()->with('success', 'Leader created successfully');
    // }


    public function store(Request $request)
{
    $validate = $request->validate([
        'name' => 'nullable|string|max:50',
        'title' => 'nullable|string|max:50',
        'position' => 'nullable|string|max:50',
        'button_text' => 'nullable|string|max:50',
        'description' => 'nullable|string|max:50',
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

        // 🔧 Set fallback for button_text if empty or missing
        $validate['button_text'] = $validate['button_text'] ?? 'Learn More';

        Executive::create($validate);

        session()->put('t-success', 'Executive created successfully');
    } catch (Exception $e) {
        session()->put('t-error', $e->getMessage());
    }

    return redirect()->route('admin.executive.index')->with('success', 'Executive created successfully');
}

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $executive = Executive::findOrFail($id);
        $executive->image_url = asset('/' . $executive->image);
        return response()->json($executive);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Executive $leader, $id)
    {
        $executive = Executive::findOrFail($id);
        return view('backend.layouts.executive.edit', compact('executive'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:50',
            'title' => 'required|string|max:50',
            'position' => 'required|string|max:50',
            'button_text' => 'required|string|max:50',
            'description' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        try {
            $executive = Executive::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($executive->image && file_exists(public_path($executive->image))) {
                    Helper::fileDelete(public_path($executive->image));
                }
                $validate['image'] = Helper::fileUpload($request->file('image'), 'image', time() . '_' . getFileName($request->file('image')));
            }

            $executive->update($validate);
            session()->put('t-success', 'Executive updated successfully');
        } catch (Exception $e) {
            session()->put('t-error', $e->getMessage());
        }

        return redirect()->route('admin.executive.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Executive::findOrFail($id);
            if ($data->image && file_exists(public_path($data->image))) {
                Helper::fileDelete(public_path($data->image));
            }
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'executive deleted successfully!'
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
        $data = Executive::findOrFail($id);
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
