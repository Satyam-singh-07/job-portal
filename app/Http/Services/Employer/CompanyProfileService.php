<?php

namespace App\Http\Services\Employer;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CompanyProfileService
{
    public function update($user, $request)
    {
        if ($request->hasFile('logo')) {
            $user->logo = $this->handleLogoUpload($request->file('logo'), $user);
        }

        $user->update($request->only([
            'company_name',
            'industry',
            'website',
            'tagline',
            'team_size',
            'summary',
        ]));

        return $user;
    }

    private function handleLogoUpload($file, $user): string
    {
        if ($user->logo && Storage::exists($user->logo)) {
            Storage::delete($user->logo);
        }

        $filename = 'company-logos/'.Str::uuid().'.webp';

        // $image = Image::make($file)
        //     ->fit(300, 300)
        //     ->encode('webp', 85);

        Storage::put($filename, (string) $file);

        return $filename;
    }

    public function uploadLogo($user, $file): string
    {
        $disk = config('filesystems.default'); // works for local, s3, etc.

        // 1️⃣ Delete old logo safely
        if ($user->logo && Storage::disk($disk)->exists($user->logo)) {
            Storage::disk($disk)->delete($user->logo);
        }

        // 2️⃣ Generate unique filename
        $filename = 'company-logos/'.Str::uuid().'.webp';

        // 3️⃣ Store file properly (public visibility)
        Storage::disk($disk)->putFileAs(
            'company-logos',
            $file,
            basename($filename),
            [
                'visibility' => 'public',
            ]
        );

        // 4️⃣ Save path in DB
        $user->update([
            'logo' => $filename,
        ]);

        // 5️⃣ Return full storage URL (correct way)
        return Storage::disk($disk)->url($filename);
    }
}
