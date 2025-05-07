<?php

namespace App\Http\Controllers\Web\Backend;


use Exception;
use App\Helpers\Helper;

use App\Models\Commitment;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use App\Models\CommitmentDetail;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CommitmentDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CommitmentDetail::with(['commitment'])->orderBy('id', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('commitment', function ($data) {
                    return "<a href='" . route('admin.commitment.show', $data->commitment_id) . "'>" . $data->commitment->title . "</a>";
                })
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
                                <a href="#" type="button" onclick="goToEdit(' . $data->id . ')" class="btn btn-primary fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-edit"></i>
                                </a>
                                <a href="#" type="button" onclick="event.preventDefault(); viewModalContent(' . $data->id . ')" class="btn btn-success fs-14 text-white delete-icn" title="View">
                                    <i class="fe fe-eye"></i>
                                </a>
                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['commitment', 'image', 'status', 'action'])
                ->make();
        }


        return view("backend.layouts.commitment_details.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $commitments = Commitment::where('status', 'active')->get();
        return view('backend.layouts.commitment_details.create', compact('commitments'));
    }





    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:50',
            'commitment_id' => 'required|exists:commitments,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        try {
            if ($request->hasFile('image')) {
                $validate['image'] = Helper::fileUpload(
                    $request->file('image'),
                    'commitment_details',
                    time() . '_' . getFileName($request->file('image'))
                );
            }


            CommitmentDetail::create($validate);

            session()->put('t-success', 'CommitmentDetail created successfully');
        } catch (Exception $e) {
            session()->put('t-error', $e->getMessage());
        }

        return redirect()->route('admin.commitment_detail.index')->with('success', 'Commitment_detail created successfully');
    }

    /**
     * Display the specified resource.
     */

    // public function show($id)
    // {
    //     $CommitmentDetail = CommitmentDetail::findOrFail($id);
    //     $CommitmentDetail->image_url = asset('/' . $CommitmentDetail->image);

    //     // return view('backend.layouts.commitment_details.show', compact('CommitmentDetail'));
    //     return response()->json($CommitmentDetail);
    // }

    public function show($id)
{
    $commitmentDetail = CommitmentDetail::with('commitment')->findOrFail($id);

    return response()->json([
        'id' => $commitmentDetail->id,
        'title' => $commitmentDetail->title,
        'description' => $commitmentDetail->description,
        'image_url' => asset($commitmentDetail->image), 
        'commitment' => [
            'id' => $commitmentDetail->commitment->id,
            'title' => $commitmentDetail->commitment->title,
        ],
    ]);
}



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommitmentDetail $leader, $id)
    {
        $CommitmentDetail = CommitmentDetail::findOrFail($id);
        $commitments = Commitment::where('status', 'active')->get();
        return view('backend.layouts.commitment_details.edit', compact('CommitmentDetail', 'commitments'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'title' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:50',
            'commitment_id' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        try {
            $CommitmentDetail = CommitmentDetail::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($CommitmentDetail->image && file_exists(public_path($CommitmentDetail->image))) {
                    Helper::fileDelete(public_path($CommitmentDetail->image));
                }
                $validate['image'] = Helper::fileUpload($request->file('image'), 'image', time() . '_' . getFileName($request->file('image')));
            }

            $CommitmentDetail->update($validate);
            session()->put('t-success', 'CommitmentDetail updated successfully');
        } catch (Exception $e) {
            session()->put('t-error', $e->getMessage());
        }

        return redirect()->route('admin.commitment_detail.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = CommitmentDetail::findOrFail($id);
            if ($data->image && file_exists(public_path($data->image))) {
                Helper::fileDelete(public_path($data->image));
            }
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'CommitmentDetail deleted successfully!'
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
        $data = CommitmentDetail::findOrFail($id);
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
