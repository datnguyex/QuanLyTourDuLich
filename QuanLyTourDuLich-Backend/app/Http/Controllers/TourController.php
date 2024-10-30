<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Images;
use App\Models\Schedule;
use Storage;
use File;
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
            $tours = Tour::with('images')->get();
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
            //Make vaildate for variable
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'duration' => 'required|integer',
                'price' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'location' => 'required|string',
                'images.*' => 'required|file|image|mimes:png,jpg,svg',
                'schedules' => 'required',
            ]);

            $tour = Tour::create($validatedData);

            //Get array schedules
            $schedules = json_decode($validatedData['schedules'], true);
            foreach($schedules as $item) {
                //Change string json into array
                // $scheduleData = json_decode($item, true);
                $schedule = Schedule::create([
                    'name' => $item['name_schedule'],
                    'time' => $item['time_schedule'],
                    'tour_id' => $tour->id,
                ]);
            }

            // Handle file uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->getClientOriginalName();
                    Storage::disk('public')->put($path, File::get($image));
                    $image = Images::create([
                        'tour_id' => $tour->id,
                        'image_url' => $path,
                        'alt_text' => $request->input('alt_text', 'Default alt text'),
                    ]);

                    // http://127.0.0.1:8000/images/7B9dDErH16ywJWIhieXV9sRYitUb0dC5qNgJ0jCo.png
                }

            }

            return response()->json([
                'message' => "Tour successfully created",
                'tour' => $tour,
                'image' => $image,
                'schedule' => $schedule,
            ], 200);



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
    /**
 * Update tour
 * @param \Illuminate\Http\Request $request
 * @param int $id
 * @return mixed|\Illuminate\Http\JsonResponse
 */
    public function update(Request $request, $id)
    {
        // dd($request);
        try {
            // Find tour to update
            $tour = Tour::find($id);
            // dd($tour);
            // Check if tour exists
            if (!$tour) {
                return response()->json([
                    'message' => "Tour not found",
                ], 404);
            }

            // Validate data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'duration' => 'required|integer',
                'price' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'location' => 'required|string',
                'images.*' => 'file|image|mimes:png,jpg,svg',
                'schedules' => 'required',
            ]);

            // Update tour
            $tour->update($validatedData);

            // Update schedules if provided
            if ($request->has('schedules')) {
                // Delete existing schedules
                $tour->schedules()->delete();

                // Get array of new schedules
                $schedules = json_decode($validatedData['schedules'], true);
                foreach ($schedules as $item) {
                    Schedule::create([
                        'name' => $item['name_schedule'],
                        'time' => $item['time_schedule'],
                        'tour_id' => $tour->id,
                    ]);
                }
            }

            // Handle file uploads
            if ($request->hasFile('images')) {
                // Delete existing images
                $tour->images()->delete();

                // Upload new images
                foreach ($request->file('images') as $image) {
                    Images::create([
                        'tour_id' => $tour->id,
                        'image_url' => $image->store('images', 'public'),
                        'alt_text' => $request->input('alt_text', 'Default alt text'),
                    ]);
                }
            }

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
            //Write bug on file log
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
            $tour = Tour::with('images', 'schedules')->find($id);
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

    /**
     * Look for tour with location
     * @param mixed $query
     * @param mixed $location
     * @return mixed
     */
    public function findByLocation($location)
    {
        try {
            $results = Tour::findByLocation($location)->get();
            // Check if results are found
            if ($results->isEmpty()) {
                return response()->json([
                    'message' => 'Tour Not Foud.'
                ], 404);
            }

            // Return the results
            return response()->json($results, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display tour with category
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function findByCategory($category)
    {
        // Validate the incoming request
        try {
            // Use the scope method to find tours by category
            $results = Tour::findByCategory($category)->get();

            // Check if results are found
            if ($results->isEmpty()) {
                return response()->json([
                    'message' => 'No tours found for this category.'
                ], 404);
            }

            // Return the results
            return response()->json($results, 200);

        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Method get count tour upload
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function countTours()
    {
        try {
            // Lấy số lượng tour đã đăng
            $count = Tour::count();
            // Trả về số lượng tour
            return response()->json([
                'count' => $count
            ], 200);

        } catch (\Exception $e) {
            // Xử lý lỗi và trả về thông báo
            return response()->json([
                'message' => 'An error occurred while counting tours.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Method update stutus
     * @param mixed $tatus
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function updateStatus($tatus, $id)
    {

        try {
            //Check tour not foud
            $tour = Tour::findOrFail($id);
            // Check if results are found
            if ($tour->isEmpty()) {
                return response()->json([
                    'message' => 'No tours found.'
                ], 404);
            }
            $tour->availability = $tatus;
            $tour->save();

            return response()->json([
                'message' => 'Tour status updated successfully.',
                'tour' => $tour
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Tour not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating tour status.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function sortTours(Request $request)
    {
        $sortBy = $request->query('sort', 'price');
        try {
            $tours = Tour::query();
            // Sắp xếp theo tiêu chí
            switch ($sortBy) {
                case 'price':
                    $tours->orderBy('price', 'desc');
                    break;
                case 'latest':
                    $tours->orderBy('created_at', 'desc');
                    break;
                default:
                    return response()->json(['message' => 'Invalid sort parameter.'], 400);
            }

            $results = $tours->get();
            return response()->json($results, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while sorting tours.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}