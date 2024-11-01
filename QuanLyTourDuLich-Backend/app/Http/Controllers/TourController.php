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
      *  Hàm mã hóa
      * @param mixed $id
      * @return string
      */
    public function encrypt($id)
    {
        $secretKey = env('SECRET_KEY', 'tourtravelstore');
        $cipher = 'AES-256-CBC';
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

        // Mã hóa ID
        $encrypted = openssl_encrypt($id, $cipher, $secretKey, 0, $iv);

        // Trả về mã hóa kèm IV để giải mã sau này
        return base64_encode($encrypted . '::' . $iv);
    }

    public function decrypt($data)
    {
        $secretKey = env('SECRET_KEY', 'tourtravelstore');
        $cipher = 'AES-256-CBC';

        list($encryptedData, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encryptedData, $cipher, $secretKey, 0, $iv);
    }


    /**
     * Get tours
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $tours = Tour::with('images', 'schedules')->paginate($perPage);
            // Tạo mảng tour tùy chỉnh
            $toursArray = $tours->getCollection()->map(function ($tour) {
                return [
                    'id' => encrypt($tour->id), // Hoặc trường khác bạn muốn
                    'title' => $tour->title,
                    'description' => $tour->description,
                    'duration' => $tour->duration,
                    'price' => $tour->price,
                    'start_date' => $tour->start_date,
                    'end_date' => $tour->end_date,
                    'location' => $tour->location,
                    'availability' => $tour->availability,
                    'images' => $tour->images,
                    'schedules' => $tour->schedules
                ];
            });
            return response()->json([
                'tours' => $toursArray,
                'links' => [
                    'next' => $tours->nextPageUrl(),
                    'prev' => $tours->previousPageUrl(),
                ],
                'meta' => [
                    'current_page' => $tours->currentPage(), // Phương thức currentPage()
                    'last_page' => $tours->lastPage(),
                    'per_page' => $tours->perPage(),
                    'total' => $tours->total(),
                ]
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
                $schedule = Schedule::create([
                    'name' => $item['name_schedule'],
                    'time' => $item['time_schedule'],
                    'tour_id' => $tour->id,
                ]);
            }

            // Handle file uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = time() . '_' . $image->getClientOriginalName();
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
     * @param int $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $hashId)
    {
        try {
            $id = decrypt($hashId); // Decrypt the hash ID
            $tour = Tour::with('images', 'schedules')->find($id);
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
            $uploadedImages = [];
            // Handle file uploads
            if ($request->hasFile('images')) {
                //Delete tour exitting
                $images = $tour->images;
                foreach($images as $image){
                    $filePath = public_path('/images/' . $image->image_url);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    $image->delete();
                }
                // Upload new images
                foreach ($request->file('images') as $image) {
                    $path = time() . '_' . $image->getClientOriginalName();
                    Storage::disk('public')->put($path, File::get($image));
                    $uploadedImages[] =  $image;
                    Images::create([
                        'tour_id' => $tour->id,
                        'image_url' => $path,
                        'alt_text' => $request->input('alt_text', 'Default alt text'),
                    ]);
                }
            }

            return response()->json([
                'message' => "Tour successfully updated",
                'tour' => $tour,
                'image' => $uploadedImages,
                'schedules' => $schedules,
                'id' => encrypt($tour->id), // Updated to encrypt the tour ID
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
    public function destroy($hashId)
    {
        try {
            $id = decrypt($hashId); // Decrypt the hash ID
            $tour = Tour::find($id);
            // Check if tour exists
            if (!$tour) {
                return response()->json([
                    "message" => "Tour not found",
                ], 404);
            }

            // Delete tour
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
            $tours = Tour::whereIn('id', $request->input('ids'))->get(); // Assuming 'ids' is the key in the request
            // Check if tour not exists
            if ($tours->isEmpty()) {
                return response()->json([
                    "message" => "Tour not found",
                ], 404);
            }

            // Delete item of array tours
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

    public function show($hashId)
    {
        try {
            //Decrypt id
            $id = decrypt($hashId);

            //
            $tour = Tour::with('images', 'schedules')->find($id);
            //Check if tour not exits
            if (!$tour) {
                return response()->json([
                    "message" => "Tour not found sdfsdfsdfdư" ,
                ], 404);
            }

            //Return when find the tour
            return response()->json([
                "tour" => $tour,
                "id" => encrypt($tour->id) // Updated to encrypt the tour ID
            ], 200);
        }catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Xử lý trường hợp giải mã không thành công
            return response()->json([
                "message" => "Tour Not Found",
                "error" => $e->getMessage(),
            ], 400); // 400 Bad Request
        } catch (\Exception $e) {
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