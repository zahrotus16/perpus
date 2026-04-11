<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $settings = \App\Models\Setting::pluck('value', 'key');
        return view('admin.settings.index', compact('user', 'settings'));
    }

    public function updateAppSettings(Request $request)
    {
        $request->validate([
            'app_name'      => 'required|string|max:255',
            'app_logo'      => 'nullable',
            'loan_limit'    => 'required|integer|min:1',
            'fine_per_day'  => 'required|integer|min:0',
        ]);

        $data = $request->only('app_name', 'loan_limit', 'fine_per_day');

        if ($request->hasFile('app_logo')) {
            // Delete old logo if exists
            $oldLogo = \App\Models\Setting::where('key', 'app_logo')->value('value');
            if ($oldLogo && \Illuminate\Support\Facades\Storage::disk('public')->exists($oldLogo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('app_logo')->store('logo', 'public');
            $data['app_logo'] = $path;
        }

        foreach ($data as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Clear caches to ensure changes are reflected
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');

        return back()->with('success', 'Pengaturan aplikasi berhasil diperbarui!');
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('foto', $filename, 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Profil admin berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password admin berhasil diubah!');
    }

    public function staff()
    {
        return $this->index(); // Placeholder
    }

    public function roles()
    {
        return $this->index(); // Placeholder
    }
}
