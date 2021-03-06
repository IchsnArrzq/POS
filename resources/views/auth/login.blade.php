@extends('layouts.login.app')

@section('content')
<div class="main-wrapper">
    <div class="page-wrapper full-page-wrapper d-flex align-items-center justify-content-center">
      <main class="auth-page">
        <div class="mdc-layout-grid">
          <div class="mdc-layout-grid__inner">
            <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-6-tablet">
              <div class="mdc-card">
                <form method="POST" action="{{ route('login') }}">
                @csrf
                  <div class="mdc-layout-grid">
                    <div class="mdc-layout-grid__inner">
                      <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <div class="mdc-text-field w-100">
                          <input class="mdc-text-field__input" name="username" id="text-field-hero-input" @error('username') value="{{ old('username') }}" @enderror autofocus required>
                          <div class="mdc-line-ripple"></div>
                          <label for="text-field-hero-input" class="mdc-floating-label">Username</label>
                            {{-- @error('username')
                                <label>{{ $message }}</label>
                            @enderror --}}
                        </div>
                      </div>
                      <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <div class="mdc-text-field w-100">
                          <input class="mdc-text-field__input" name="password" type="password" id="text-field-hero-input" required>
                          <div class="mdc-line-ripple"></div>
                          <label for="text-field-hero-input" class="mdc-floating-label">Password</label>
                            {{-- @error('password')
                                {{ $message }}
                            @enderror --}}
                        </div>
                      </div>
                      <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <button type="submit" class="mdc-button mdc-button--raised w-100">
                          Login
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
          </div>
        </div>
      </main>
    </div>
  </div>
@endsection
