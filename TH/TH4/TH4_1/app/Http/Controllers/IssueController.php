<?php

namespace App\Http\Controllers;
use App\Models\Computer;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Sử dụng paginate thay vì all()
        $issues = Issue::with('computer')->paginate(10); // Lấy 5 bản ghi mỗi trang
        return view('issues.index', compact('issues'));
    }

    // Hiển thị form tạo đồ án mới
    public function create()
    {
        $computers = Computer::all(); // Lấy danh sách sinh viên để chọn
        return view('issues.create', compact('computers'));
    }

    // Lưu đồ án mới
    public function store(Request $request)
    {
        try{
            $request->validate([
            'computer_id' => 'required',
            'reported_by' => 'required|max:50',
            'reported_date' => 'required|date',
            'description',
            'urgency' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Open,In Progress,Resolved',
            


        ]);

        Issue::create($request->all());

        return redirect()->route('issues.index')->with('success', 'Đồ án đã được thêm thành công!');
    } catch (\Exception $e) {
        Log::error('Error add issue: ' . $e->getMessage());

        return redirect()->back()
            ->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()])
            ->withInput();
    }
    }

    // Hiển thị form chỉnh sửa đồ án
    public function edit($id)
    {
        $issue = Issue::findOrFail($id);
        $computers = Computer::all();
        return view('issues.edit', compact('issue', 'computers'));
    }

    // Cập nhật thông tin đồ án
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'reported_by' => 'required|max:100',
                'reported_date' => 'required|date',
                'urgency' => 'required|in:low,medium,high',
                'status' => 'required|in:open,in progress,resolved',
                'computer_id' => 'required',
            ]);

            $issue = Issue::findOrFail($id);
            $issue->update($request->all());

            return redirect()->route('issues.index')->with('success', 'Issue được cập nhật thành công!');
        } catch (\Exception $e) {
            Log::error('Error updating issue: ' . $e->getMessage());

            return redirect()->back()
                ->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()])
                ->withInput();
        }
    }

    

    // Xóa đồ án
    public function destroy($id)
    {
        $issue = Issue::findOrFail($id);
        $issue->delete();

        return redirect()->route('issues.index')->with('success', 'Đồ án đã được xóa thành công!');
    }
}
