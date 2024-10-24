<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

        $users = User::all();
        return response()->json([
            'users'  => $users
        ], 200);
        // return view('users.index', compact('users'));
    }

   
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Tìm người dùng theo ID
        $user->delete(); // Xóa người dùng
    
        return response()->json([
            'message' => 'Người dùng đã được xóa thành công.'
        ], 200);
    }
    

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:100',
                'username' => [
                    'required', 
                    'max:100', 
                    'unique:users', 
                    'regex:/[a-zA-Z]/', 
                    'not_regex:/^\s/', 
                    'not_regex:/\s{2,}/'
                ],
                'password' => 'required|min:6',
                'role' => 'required|in:1,2,3',
            ], [
                'name.required' => 'Vui lòng nhập tên.',
                'username.unique' => 'Tên người dùng đã tồn tại.',
                'username.regex' => 'Tên người dùng phải chứa ít nhất một chữ cái.',
                'username.not_regex' => 'Không được có khoảng trắng đầu hoặc hai khoảng trắng liên tiếp.',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
                'role.in' => 'Vai trò không hợp lệ.',
            ]);
    
            $user = User::create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'password' => bcrypt($validatedData['password']),
                'role' => $validatedData['role'],
            ]);
    
            return response()->json([
                'message' => 'Người dùng đã được thêm thành công.',
                'user' => $user
            ], 201);
    
        } catch (\Exception $e) {
            // Ghi lại lỗi để phân tích
            \Log::error('Lỗi khi thêm người dùng: ' . $e->getMessage());
    
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi thêm người dùng.',
                'error' => $e->getMessage() // Bạn có thể chọn không hiển thị thông tin lỗi chi tiết cho người dùng
            ], 500);
        }
    }
    

    public function update(Request $request, $id)
{
    try {
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|max:100',
            'username' => [
                'required', 
                'max:100', 
                'regex:/[a-zA-Z]/', // phải có ít nhất một chữ cái
                'not_regex:/^\s/', // không được có khoảng trắng đầu tiên
                'not_regex:/\s{2,}/', // không được có hai khoảng trắng liên tiếp
                
            ],
            'password' => 'nullable|min:6', // chỉ xác thực mật khẩu nếu có nhập
            'role' => 'required|in:1,2,3',
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'username.regex' => 'Tên người dùng phải chứa ít nhất một chữ cái.',
            'username.not_regex' => 'Tên người dùng không được có khoảng trắng đầu hoặc hai khoảng trắng liên tiếp.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'role.in' => 'Vai trò không hợp lệ.',
        ]);

        // Nếu trường mật khẩu được nhập, mã hóa mật khẩu mới
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            // Nếu không có mật khẩu mới, xóa nó khỏi mảng dữ liệu đã xác thực
            unset($validatedData['password']);
        }

        // Cập nhật thông tin người dùng
        $user->update($validatedData);

        // Trả về thông báo thành công và dữ liệu người dùng đã cập nhật
        return response()->json([
            'message' => 'Người dùng đã được cập nhật thành công.',
        ], 200);

    } catch (\Exception $e) {
        // Ghi lại lỗi để phân tích
        \Log::error('Lỗi khi cập nhật người dùng: ' . $e->getMessage());

        return response()->json([
            'message' => 'Đã xảy ra lỗi khi cập nhật người dùng.',
            'error' => $e->getMessage() // Bạn có thể chọn không hiển thị thông tin lỗi chi tiết cho người dùng
        ], 500);
    }
}



}
