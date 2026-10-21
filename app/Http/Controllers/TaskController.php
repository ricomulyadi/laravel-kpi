<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'source' => ['required', Rule::in(['Internal', 'Client'])],
            'department' => ['required', Rule::in(['Graphic Design', 'Visual Production'])],
            'task_type' => [
                'required',
                Rule::in([
                    'Carousel', 'Feed / Story', 'Cover Reels',
                    'Key Visual / Poster', 'Videografi', 'Fotografi',
                    'Video Editing', 'Motion Graphic', 'Lainnya',
                ]),
            ],
            'task_name' => ['required', 'string', 'max:180'],
            'project_name' => [
                Rule::requiredIf($request->input('source') === 'Client'),
                'nullable',
                'string',
                'max:255',
            ],
            'deadline' => ['required', 'date', 'after_or_equal:today'],
            'brief' => ['nullable', 'string', 'max:5000'],
        ], [
            'source.required' => 'Pilih sumber pekerjaan.',
            'department.required' => 'Pilih departemen.',
            'task_type.required' => 'Pilih jenis tugas.',
            'task_name.required' => 'Isi nama tugas terlebih dahulu.',
            'project_name.required' => 'Nama proyek/klien wajib diisi untuk pekerjaan Client Project.',
            'deadline.required' => 'Pilih deadline tugas.',
            'deadline.after_or_equal' => 'Deadline tidak boleh sebelum hari ini.',
        ]);

        $task = DB::transaction(function () use ($validated, $request) {
            $departmentCode = $validated['department'] === 'Graphic Design' ? 'D' : 'V';

            // Row D/V is created by the task_sequences migration.
            // Locking it ensures two simultaneous requests do not reuse a sequence number.
            $sequence = DB::table('task_sequences')
                ->where('department_code', $departmentCode)
                ->lockForUpdate()
                ->first();

            if (!$sequence) {
                throw new \RuntimeException('Sequence tugas belum tersedia. Jalankan migrasi database.');
            }

            $number = (int) $sequence->next_number;

            DB::table('task_sequences')
                ->where('department_code', $departmentCode)
                ->update([
                    'next_number' => $number + 1,
                    'updated_at' => now(),
                ]);

            $taskCode = sprintf('PRD-%s-%04d', $departmentCode, $number);

            return Task::create([
                'task_code' => $taskCode,
                'user_id' => $request->user()->id,
                'source' => $validated['source'],
                'department' => $validated['department'],
                'project_name' => $validated['source'] === 'Client'
                    ? ($validated['project_name'] ?? null)
                    : null,
                'task_type' => $validated['task_type'],
                'task_name' => $validated['task_name'],
                'brief' => $validated['brief'] ?? null,
                'deadline' => $validated['deadline'],
                'status' => 'draft',
            ]);
        });

        return redirect()
            ->route('tasks.create')
            ->with('success', "Tugas {$task->task_code} berhasil dicatat.");
    }
}
