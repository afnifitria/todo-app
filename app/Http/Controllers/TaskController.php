<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Menampilkan daftar tugas dan daftar list berdasarkan query pencarian
    public function index(Request $request)
    {
        // Mendapatkan input pencarian dari request
        $query = $request->input('query');

        // Jika ada query pencarian
        if ($query) {
            // Mencari task berdasarkan nama atau deskripsi yang cocok dengan query
            $tasks = Task::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->latest() // Urutkan berdasarkan terbaru
                ->get();

            // Mencari TaskList berdasarkan nama atau task yang cocok dengan query
            $lists = TaskList::where('name', 'like', "%{$query}%")
                ->orWhereHas('tasks', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                })
                ->with('tasks') // Menyertakan relasi tasks
                ->get();

            // Jika tidak ada tugas ditemukan, ambil daftar list dengan tugas yang sudah dimuat
            if ($tasks->isEmpty()) {
                $lists->load('tasks');
            } else {
                // Jika ada tugas, filter hanya tugas yang sesuai dengan query
                $lists->load(['tasks' => function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                }]);
            }
        } else {
            // Jika tidak ada query pencarian, ambil semua tugas dan task list
            $tasks = Task::latest()->get();
            $lists = TaskList::with('tasks')->get();
        }

        // Menyiapkan data untuk dikirim ke view
        $data = [
            'title' => 'Home', // Judul halaman
            'lists' => $lists, // Daftar task lists
            'tasks' => $tasks, // Daftar tasks
            'priorities' => Task::PRIORITIES // Menyertakan prioritas dari model Task
        ];

        // Mengembalikan tampilan halaman home dengan data yang sudah disiapkan
        return view('pages.home', $data);
    }

    // Menyimpan tugas baru
    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
        $request->validate([
            'name' => 'required|max:100', // Nama tugas harus diisi dan maksimal 100 karakter
            'description' => 'max:255', // Deskripsi tugas maksimal 255 karakter
            'list_id' => 'required' // ID daftar list harus diisi
        ]);

        // Membuat tugas baru
        Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority, // Prioritas tugas
            'list_id' => $request->list_id // ID list tempat tugas akan disimpan
        ]);

        // Mengarahkan kembali ke halaman sebelumnya setelah tugas disimpan
        return redirect()->back();
    }

    // Menandai tugas sebagai selesai
    public function complete($id)
    {
        // Temukan tugas berdasarkan ID dan perbarui statusnya menjadi selesai
        Task::findOrFail($id)->update([
            'is_completed' => true
        ]);

        // Mengarahkan kembali ke halaman sebelumnya
        return redirect()->back();
    }

    // Menghapus tugas
    public function destroy($id)
    {
        // Temukan tugas berdasarkan ID dan hapus
        Task::findOrFail($id)->delete();

        // Mengarahkan kembali ke halaman utama
        return redirect()->route('home');
    }

    // Menampilkan detail tugas
    public function show($id)
    {
        // Menyiapkan data untuk halaman detail tugas
        $data = [
            'title' => 'Task', // Judul halaman
            'lists' => TaskList::all(), // Mengambil semua task list
            'task' => Task::findOrFail($id), // Mencari tugas berdasarkan ID
        ];

        // Mengembalikan tampilan halaman detail tugas dengan data yang disiapkan
        return view('pages.details', $data);
    }

    // Mengubah list tempat tugas berada
    public function changeList(Request $request, Task $task)
    {
        // Validasi ID list yang baru
        $request->validate([
            'list_id' => 'required|exists:task_lists,id', // Pastikan ID list ada dalam tabel task_lists
        ]);

        // Perbarui ID list pada tugas
        Task::findOrFail($task->id)->update([
            'list_id' => $request->list_id
        ]);

        // Mengarahkan kembali dengan pesan sukses
        return redirect()->back()->with('success', 'List berhasil diperbarui!');
    }

    // Memperbarui tugas
    public function update(Request $request, Task $task)
    {
        // Validasi data yang diterima dari request
        $request->validate([
            'list_id' => 'required', // ID list harus diisi
            'name' => 'required|max:100', // Nama tugas harus diisi dan maksimal 100 karakter
            'description' => 'max:255', // Deskripsi tugas maksimal 255 karakter
            'priority' => 'required|in:low,medium,high' // Prioritas harus salah satu dari low, medium, atau high
        ]);

        // Perbarui data tugas dengan data yang diterima
        Task::findOrFail($task->id)->update([
            'list_id' => $request->list_id,
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority
        ]);

        // Mengarahkan kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Task berhasil diperbarui!');
    }
}
