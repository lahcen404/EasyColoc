@extends('layouts.app')

@section('content')
    <!-- Pass the header title to the layout -->
    @php $header = 'Account Settings'; @endphp

    <div class="space-y-8">
        <!-- 1. Update Profile Information -->
        <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-2xl border-l-4 border-brand-dark">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- 2. Update Password -->
        <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-2xl border-l-4 border-brand-medium">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- 3. Delete Account -->
        <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-2xl border-l-4 border-red-400">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
