<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class TourController extends Controller
{
    /**
     * Encode data to JSON
     * @param $data
     * @return string
     */
    protected function jsonEncode($id)
    {
        return json_encode($id);
    }


    /**
     * Get tours
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $tours = Tour::all();
            return response()->json([
                'tours' => $tours
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'error'=> $e->getMessage()
            ],500);
        }
    }

     /**
      * Create tour
      * @param \Illuminate\Http\Request $request
      * @return mixed|\Illuminate\Http\JsonResponse
      */
     public function store(Request $request)
     {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'duration' => 'required|integer',
                'price' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'location' => 'required|string',
                'availability' => 'required',
                'image' => 'required|string|max:2048',
            ]);

            $tour = Tour::create($validatedData);

            return response()->json([
                'message' => "Tour successfully created",
                'tour' => $tour
            ], 201);
        } catch (\Exception $e) {
            // Ghi lỗi vào file log
            Log::error('Error creating tour: ' . $e->getMessage());

            return response()->json([
                'message' => "something really wrong",
                'error' => $e->getMessage()
            ], 500);
        }
     }

     /**
      * Update tour
      * @param \Illuminate\Http\Request $request
      * @return mixed|\Illuminate\Http\JsonResponse
      */
    public function update(Request $request, $id)
    {
        try {

            // Find tour to update
            $tour = Tour::find($id);

            // Check if tour exists
            if (!$tour) {
                return response()->json([
                    'message' => "Tour not found",
                ], 404);
            }

            /**
             * @var mixed
             * Make validate for a tour
             */
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'duration' => 'required|integer',
                'price' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'location' => 'required|string',
                'availability' => 'required',
                'image' => 'required|string|max:2048',
            ]);

            // Update tour
            $tour->update($validatedData);

            return response()->json([
                'message' => "Tour successfully updated",
                'tour' => $tour
            ], 200);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error updating tour: ' . $e->getMessage());

            return response()->json([
                'message' => "Something went wrong",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Destroy tour
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $tour = tour::find($id);
            //check if tour exist
            if (!$tour) {
                return response()->json([
                    "message" => "Tour not found",
                ], 404);
            }

            //Delete tour
            $tour->delete();

            return response()->json([
                "message" => "Destroy successfully",
            ], 200);
        } catch (\Exception $e) {
            // Write bug on file log
            Log::error("Error destroy tour". $e->getMessage());
            return response()->json([
                "message" => "Something Went Wrong",
                "error" =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Destroy many tours
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroyTours(Request $request)
    {
        try {
            $tours = Tour::whereIn('id', $request)->get();
            // dd($tours);
            //Check if tour not exits
            if (count($tours) == 0) {
                return response()->json([
                    "message" => "Tour not found",
                ], 404);
            }

            //Delete item of array tours
            foreach ($tours as $tour) {
                $tour->delete();
            }
            return response()->json([
                "message" => "Destroy Tour successfully",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Something Went Wrong",
                "error" => $e
            ], 500);
        }
    }

    public function show($id)
    {
        // // $endeco = json_decode($id);

        // if (isset($id)) {
        //     $secretKey = "MinhHiep"; // Khóa bí mật
        //     // Hash HMAC
        //     $hashedId = json_encode( $id);
        // }

        // // $newHashedId = hash_hmac('sha256', $id, $secretKey);
        // // //  dd($hashedId, $newHashedId);
        // // if($newHashedId == $hashedId )
        // // {
        //     dd($hashedId);
        // // }
        try {
            $tour = tour::find($id);
            //Check if tour not exits
            if (!$tour) {
                return response()->json([
                    "message" => "Tour not found",
                ], 404);
            }
            //Return when find the tour
            return response()->json([
                "tour" => $tour,
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                "message"=> "Something Went Wrong",
                "error"=> $e->getMessage()
            ], 500);
        }
    }
}