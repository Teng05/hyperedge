<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::where('teacher_id', Auth::id())->orderBy('order')->get();
        return view('teacher.modules.index', compact('modules'));
    }

    public function create()
    {
        return view('teacher.modules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'order'       => 'required|integer|min:1',
        ]);

        $module = Module::create([
            'teacher_id'  => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'order'       => $request->order,
            'is_active'   => true,
            'is_locked'   => $request->order > 1,
        ]);

        return redirect()->route('teacher.modules.show', $module->id)
                         ->with('success', 'Module created! Now add lessons.');
    }

    public function show($id)
    {
        $module = Module::with(['lessons', 'quiz.questions'])
                        ->where('teacher_id', Auth::id())
                        ->findOrFail($id);
        return view('teacher.modules.show', compact('module'));
    }

    public function edit($id)
    {
        $module = Module::where('teacher_id', Auth::id())->findOrFail($id);
        return view('teacher.modules.edit', compact('module'));
    }

    public function update(Request $request, $id)
    {
        $module = Module::where('teacher_id', Auth::id())->findOrFail($id);
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'order'       => 'required|integer|min:1',
        ]);

        $module->update($request->only('title', 'description', 'order', 'is_active'));
        return redirect()->route('teacher.modules.show', $id)->with('success', 'Module updated!');
    }

    public function destroy($id)
    {
        $module = Module::where('teacher_id', Auth::id())->findOrFail($id);
        $module->delete();
        return redirect()->route('teacher.modules.index')->with('success', 'Module deleted.');
    }

    // Add a lesson (video link or file upload)
    public function addLesson(Request $request, $moduleId)
    {
        $module = Module::where('teacher_id', Auth::id())->findOrFail($moduleId);

        $request->validate([
            'title'     => 'required|string|max:255',
            'type'      => 'required|in:video,ppt,pdf',
            'video_url' => 'nullable|url|required_if:type,video',
            'file'      => 'nullable|file|mimes:pdf,ppt,pptx|max:51200|required_if:type,ppt,pdf',
            'order'     => 'required|integer|min:1',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store("modules/{$moduleId}/lessons", 'public');
        }

        Lesson::create([
            'module_id' => $moduleId,
            'title'     => $request->title,
            'type'      => $request->type,
            'file_path' => $filePath,
            'video_url' => $request->video_url,
            'order'     => $request->order,
        ]);

        return redirect()->route('teacher.modules.show', $moduleId)->with('success', 'Lesson added!');
    }

    public function deleteLesson($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        if ($lesson->file_path) {
            Storage::disk('public')->delete($lesson->file_path);
        }
        $lesson->delete();
        return back()->with('success', 'Lesson deleted.');
    }

    public function editLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        $module = Module::where('teacher_id', Auth::id())->findOrFail($lesson->module_id);
        return view('teacher.modules.edit_lesson', compact('lesson', 'module'));
    }

    public function updateLesson(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        $module = Module::where('teacher_id', Auth::id())->findOrFail($lesson->module_id);

        $request->validate([
            'title'                  => 'required|string|max:255',
            'type'                   => 'required|in:video,ppt,pdf',
            'video_url'              => 'nullable|url',
            'file'                   => 'nullable|file|mimes:pdf,ppt,pptx|max:51200',
            'order'                  => 'required|integer|min:1',
            'video_explanation'      => 'nullable|string',
            'code_snippet'           => 'nullable|string',
            'code_explanation_video' => 'nullable|url',
            'video_thumbnail_file'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'ppt_slides'             => 'nullable|array',
        ]);

        $data = [
            'title'                  => $request->title,
            'type'                   => $request->type,
            'video_url'              => $request->video_url,
            'order'                  => $request->order,
            'video_explanation'      => $request->video_explanation,
            'code_snippet'           => $request->code_snippet,
            'code_explanation_video' => $request->code_explanation_video,
        ];

        if ($request->has('ppt_slides')) {
            // Filter empty slides or sanitize
            $slides = [];
            foreach ($request->ppt_slides as $slide) {
                if (!empty($slide['title']) || !empty($slide['content'])) {
                    $slides[] = [
                        'title' => $slide['title'] ?? '',
                        'content' => $slide['content'] ?? '',
                    ];
                }
            }
            $data['ppt_slides'] = $slides;
        } else {
            $data['ppt_slides'] = null;
        }

        if ($request->hasFile('file')) {
            if ($lesson->file_path) {
                Storage::disk('public')->delete($lesson->file_path);
            }
            $data['file_path'] = $request->file('file')->store("modules/{$module->id}/lessons", 'public');
        }

        if ($request->hasFile('video_thumbnail_file')) {
            if ($lesson->video_thumbnail) {
                Storage::disk('public')->delete($lesson->video_thumbnail);
            }
            $data['video_thumbnail'] = $request->file('video_thumbnail_file')->store("modules/{$module->id}/thumbnails", 'public');
        }

        $lesson->update($data);

        return redirect()->route('teacher.modules.show', $module->id)->with('success', 'Subtopic updated successfully.');
    }
}
