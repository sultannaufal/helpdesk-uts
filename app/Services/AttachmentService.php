<?php

namespace App\Services;

use \Illuminate\Http\Request;

class AttachmentService
{
    /**
     * @param Request $request
     * @return string|null - Путь к файлу
     */
    public function store(Request $request): ?string
    {
        if (! $request->hasFile('attachment')) {
            return null;
        }

        return \Storage::disk('public')
            ->putFile('attachments', $request->file('attachment'));
    }

    /**
     * @param Request $request
     * @param string $oldAttachment
     * @return string|null - Путь к файлу
     */
    public function update(Request $request, ?string $oldAttachment): ?string
    {
        $shouldUseOldAttachment = $request['use_old_attachment'];
        $hasNewFile = $request->hasFile('attachment');

        if (! $shouldUseOldAttachment) {

            if ($oldAttachment) { // Удалить старый если был
                \Storage::disk('public')->delete($oldAttachment);
            }

            return $hasNewFile
                ? \Storage::disk('public')->putFile('attachments', $request->file('attachment'))
                : null;
        }

        return $oldAttachment;
    }
}
