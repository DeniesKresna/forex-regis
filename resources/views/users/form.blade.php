<div class="space-y-4">
    <div><label>Name</label><input name="name" value="{{ old('name', $user->name ?? '') }}"
            class="w-full border rounded-lg px-3 py-2"></div>
    <div><label>Phone</label><input name="phone" value="{{ old('phone', $user->phone ?? '') }}"
            class="w-full border rounded-lg px-3 py-2"></div>
    <div><label>Email</label><input name="email" type="email" value="{{ old('email', $user->email ?? '') }}"
            class="w-full border rounded-lg px-3 py-2"></div>
    <div><label>Password</label><input name="password" type="password" class="w-full border rounded-lg px-3 py-2">
        <p class="text-xs text-slate-500">Minimum 8 characters. Leave blank when editing to keep current password.</p>
    </div><label class="flex gap-2"><input type="checkbox" name="is_verified" value="1"
            @checked(old('is_verified', $user->is_verified ?? true))> Verified</label><button
        class="bg-slate-900 text-white px-4 py-2 rounded-lg">{{ $button }}</button>
</div>