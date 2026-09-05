<?php

namespace App\Livewire\Admin\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Index extends Component
{
    public string $name = '';
    public string $email = '';
    public string $username = '';
    public string $user_id = '';

    public bool $changePassword = false;
    public string $password = '';
    public string $password_confirmation = '';

    public ?string $feedbackMessage = null;

    public function mount()
    {
        $user = Auth::user();
        if ($user) {
            $this->user_id = (string) ($user->id_user ?? ($user->id ?? '1'));
            $this->username = (string) ($user->username ?? 'admin');
            $this->name = (string) ($user->nama ?? ($user->name ?? 'Admin Tigabenang'));
            $this->email = (string) ($user->email ?? 'admin@tigabenang.com');
        } else {
            $this->user_id = '1';
            $this->username = 'admin';
            $this->name = 'Admin Tigabenang';
            $this->email = 'admin@tigabenang.com';
        }
    }

    public function updateProfile()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ];

        if ($this->changePassword) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $this->validate($rules);

        $user = Auth::user();
        if ($user) {
            if (isset($user->nama)) {
                $user->nama = trim($this->name);
            }
            if (isset($user->name)) {
                $user->name = trim($this->name);
            }
            $user->email = trim($this->email);

            if ($this->changePassword && !empty($this->password)) {
                $user->password = Hash::make($this->password);
                $this->password = '';
                $this->password_confirmation = '';
                $this->changePassword = false;
            }

            $user->save();
        }

        $this->feedbackMessage = 'Profil administrator berhasil diperbarui!';
    }

    public function dismissFeedback()
    {
        $this->feedbackMessage = null;
    }

    public function render()
    {
        return view('livewire.admin.profile.index');
    }
}
