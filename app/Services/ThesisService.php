<?php

namespace App\Services;

use App\Constants\ThesisStatus;
use App\Jobs\NotificationJob;
use App\Models\Theses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ThesisService extends ThesisStatus
{

    public function isThesisExist(array $data)
    {
        $user = Auth::user();
        return $user->theses()->where('title', $data['title'])->first();
    }

    public function storeThesis(array $data)
    {
        $existing_theses = $this->isThesisExist($data);
        if ($existing_theses) {
            Storage::disk('public')->delete($existing_theses->file_path);
            $existing_theses->update([
                'abstract' => $data['abstract'],
                'file_path' => $data['document']->store('theses', 'public'),
                'status' =>  $this->Submitted
            ]);
            return $existing_theses;
        }
        Theses::create([
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'abstract' => $data['abstract'],
            'file_path' => $data['document']->store('theses', 'public'),
            'status' => $this->Submitted
        ]);
        NotificationJob::dispatch(Auth::user()->only('name', 'email', 'role'));
    }

    public function updateThesis(Theses $thesis, array $data)
    {
        $thesis->title = $data['title'];
        $thesis->abstract = $data['abstract'];
        if (isset($data['document'])) {
            Storage::disk('public')->delete($thesis->file_path);
            $file_path = $data['document']->store('theses', 'public');
            $thesis->file_path = $file_path;
        }
        $thesis->save();
    }
}
