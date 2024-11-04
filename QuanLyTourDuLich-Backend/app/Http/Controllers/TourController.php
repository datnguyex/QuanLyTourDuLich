<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\User;
use App\Models\Images;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Storage;
use File;

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
            ]);


            // Handle file uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageRecord = Images::create([
                        'tour_id' => 1,
                        'image_url' => $image->store('images', 'public'),
                        'alt_text' => $request->input('alt_text', 'Default alt text'),
                    ]);
                    // http://127.0.0.1:8000/storage/images/7B9dDErH16ywJWIhieXV9sRYitUb0dC5qNgJ0jCo.png
                }
            }

            $tour = Tour::create($validatedData);

            if($imageRecord && $tour){
                return response()->json([
                    'message' => "Tour successfully created",
                    // 'tour' => $tour
                ], 200);
            }

            return response()->json([
                'message' => "something really wrong",
            ], 500);


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
    
    // private function encryptId($id, $key) {
    //     $method = 'AES-256-CBC';
    //     $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
    //     $encryptedId = openssl_encrypt($id, $method, $key, 0, $iv);
    //     return base64_encode($iv . $encryptedId);
    // }
    
    // private function decryptId($encryptedId, $key) {
    //     $method = 'AES-256-CBC';
        
    //     $decodedUrl = urldecode($encryptedId);
    //     $decodedData = base64_decode($decodedUrl);
    //     $ivLength = openssl_cipher_iv_length($method);
    //     $iv = substr($decodedData, 0, $ivLength);
    //     $encryptedIdWithoutIv = substr($decodedData, $ivLength);
        
    //     return openssl_decrypt($encryptedIdWithoutIv, $method, $key, 0, $iv);
    // }
    
    
    public function displayNewstTour(Request $request) {
        try {
            $key = 'dat123';
            $newstTour = Tour::getLatestTours(); 
            $encryptedTours = $newstTour->map(function($tour) use ($key) {
                return [
                    'id' => (new User())->encryptId($tour->id, $key),   
                    'name' => $tour->name, 
                    'description' => $tour->description,    
                    'duration' => $tour->duration, 
                    'price' => $tour->price, 
                    'start_date' => $tour->start_date, 
                    'end_date' => $tour->end_date, 
                    'location' => $tour->location, 
                    'availability' => $tour->availability, 
                    'create_at' => $tour->create_at, 
                    'update_at' => $tour->update_at, 
                    'images' => $tour->images,
                ];
            });
            if ($newstTour->isEmpty()) {
                return response()->json([
                    "message" => "Tour not found",
                ], 404);
            } else {
                return response()->json([
                    "message" => "Get tour successfully",
                    "data" => $encryptedTours,
                ], 200);
            }
          
        } catch (QueryException $e) {
            return response()->json([
                "message" => "Database query error",
                "error" => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "An unknown error occurred",
                "error" => $e->getMessage()
            ], 500);
        }
    }
    //dat tour
    public function BookTour(Request $request) {

    }
    //xem chi tiet tour
    public function TourDetail(Request $request) {
        $key = 'dat123';
        try {
          
            $validatedData = $request->validate([
                'tour_id' => 'required',
            ], [
                'tour_id.required' => 'Tour ID is required.', 
            ]);
            $encodedTourId = $validatedData['tour_id'];
            $user = new User(); 
            $tourId = $user->decryptId($encodedTourId, $key); 
            if (!$tourId) {
                return response()->json([
                    "error" => "Invalid tour ID.",
                ], 404);
            }
    
           
            $tourDetail = Tour::getTourDetailWithImages($tourId);
            
            if ($tourDetail) {
                return response()->json([
                    "message" => "Get tour successful",
                    'data' => $tourDetail,
                ], 200);
            } else {
                return response()->json([
                    "error" => "Tour not found.",
                ], 404);
            }      
        } catch (ValidationException $e) {
            return response()->json([
                "message" => "An error occurred",
                "error" => $e->getMessage() 
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "An unexpected error occurred",
                "error" => $e->getMessage() 
            ], 500);
        }  
    }
    
    
    
}