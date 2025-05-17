<header style="background: #fff; padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
  <!-- Logo -->
  <a href="{{ url('/') }}" style="display: flex; align-items: center; text-decoration: none;">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
  </a>
  <!-- Account Icon -->
  <a href="{{ route('account') }}" style="display: flex; align-items: center;">
    <img src="{{ asset('images/account-icon.png') }}" alt="Account" style="height: 32px; border-radius: 50%;">
  </a>
</header>