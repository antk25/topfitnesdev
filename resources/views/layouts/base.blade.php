<!DOCTYPE html>
<html lang="ru">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>document.getElementsByTagName("html")[0].className += " js";</script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <livewire:styles />
    @stack('css')
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />

</head>
<body>
    @section('header')
      @include('layouts.parts.header')

      @show

    @section('content')
    @show

<footer class="footer-v5 padding-y-lg">
  <div class="container max-width-lg">
    <!-- 👇 footer intro -->
    <div class="border-bottom padding-bottom-xs text-sm@md flex@md justify-between@md items-center@md">
      <h4 class="margin-bottom-xs hide@md">Popular links</h4>
      <nav>
        <ul class="flex flex-wrap gap-xxs">
          <li><a class="footer-v5__popular-link" href="#0">Pricing</a></li>
          <li><a class="footer-v5__popular-link" href="#0">Teams</a></li>
          <li><a class="footer-v5__popular-link" href="#0">Updates</a></li>
          <li><a class="footer-v5__popular-link" href="#0">Features</a></li>
          <li><a class="footer-v5__popular-link" href="#0">Integrations</a></li>
        </ul>
      </nav>

      <a href="#" class="footer-v5__back-to-top display@md">Back to top &uarr;</a>
    </div>

    <!-- 👇 footer body -->
    <div class="padding-y-xl grid gap-md">
      <div class="col-8@lg">
        <div class="grid gap-md">
          <div class="col-6@xs col-3@md">
            <h4 class="margin-bottom-xs text-base@md">Product</h4>
            <ul class="grid gap-xs text-sm@md">
              <li><a class="footer-v5__link" href="#0">Pricing</a></li>
              <li><a class="footer-v5__link" href="#0">Teams</a></li>
              <li><a class="footer-v5__link" href="#0">Updates</a></li>
              <li><a class="footer-v5__link" href="#0">Features</a></li>
              <li><a class="footer-v5__link" href="#0">Integrations</a></li>
              <li><a class="footer-v5__link" href="#0">Support</a></li>
            </ul>
          </div>

          <div class="col-6@xs col-3@md">
            <h4 class="margin-bottom-xs text-base@md">Developers</h4>
            <ul class="grid gap-xs text-sm@md">
              <li><a class="footer-v5__link" href="#0">Documentation</a></li>
              <li><a class="footer-v5__link" href="#0">API reference</a></li>
              <li><a class="footer-v5__link" href="#0">API status</a></li>
              <li><a class="footer-v5__link" href="#0">Open source</a></li>
            </ul>
          </div>

          <div class="col-6@xs col-3@md">
            <h4 class="margin-bottom-xs text-base@md">Resources</h4>
            <ul class="grid gap-xs text-sm@md">
              <li><a class="footer-v5__link" href="#0">Tutorials</a></li>
              <li><a class="footer-v5__link" href="#0">Docs</a></li>
              <li><a class="footer-v5__link" href="#0">Community</a></li>
              <li><a class="footer-v5__link" href="#0">Case studies</a></li>
              <li><a class="footer-v5__link" href="#0">Help center</a></li>
            </ul>
          </div>

          <div class="col-6@xs col-3@md">
            <h4 class="margin-bottom-xs text-base@md">About</h4>
            <ul class="grid gap-xs text-sm@md">
              <li><a class="footer-v5__link" href="#0">Company</a></li>
              <li><a class="footer-v5__link" href="#0">Customers</a></li>
              <li><a class="footer-v5__link" href="#0">Careers</a></li>
              <li><a class="footer-v5__link" href="#0">Education</a></li>
              <li><a class="footer-v5__link" href="#0">Our story</a></li>
              <li><a class="footer-v5__link" href="#0">Press kit</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-4@lg">
        <div class="max-width-xxs">
          <div class="text-component margin-bottom-sm">
            <h4 class="text-base@md">Subscribe to our newsletter</h4>
            <p class="text-sm color-contrast-medium">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores nesciunt nostrum numquam.</p>
          </div>

          <form class="grid gap-xxxs text-sm@md">
            <input class="form-control col min-width-0" type="email" placeholder="Your email address" aria-label="Email address">
            <button class="btn btn--primary col-content">Subscribe</button>
          </form>
        </div>
      </div>
    </div>

    <!-- 👇 footer colophon -->
    <div class="border-top padding-top-sm">
      <div class="flex flex-column items-center gap-sm flex-row@md justify-between@md">
        <div>
          <p class="text-sm color-contrast-medium text-xs@md">&copy; Copyright CompanyX</p>
        </div>

        <div>
          <div class="flex flex-wrap gap-xxs text-sm@md">
            <a class="footer-v5__social-btn" href="#0">
              <svg class="icon" viewBox="0 0 16 16"><title>Follow us on Twitter</title><g><path d="M16,3c-0.6,0.3-1.2,0.4-1.9,0.5c0.7-0.4,1.2-1,1.4-1.8c-0.6,0.4-1.3,0.6-2.1,0.8c-0.6-0.6-1.5-1-2.4-1 C9.3,1.5,7.8,3,7.8,4.8c0,0.3,0,0.5,0.1,0.7C5.2,5.4,2.7,4.1,1.1,2.1c-0.3,0.5-0.4,1-0.4,1.7c0,1.1,0.6,2.1,1.5,2.7 c-0.5,0-1-0.2-1.5-0.4c0,0,0,0,0,0c0,1.6,1.1,2.9,2.6,3.2C3,9.4,2.7,9.4,2.4,9.4c-0.2,0-0.4,0-0.6-0.1c0.4,1.3,1.6,2.3,3.1,2.3 c-1.1,0.9-2.5,1.4-4.1,1.4c-0.3,0-0.5,0-0.8,0c1.5,0.9,3.2,1.5,5,1.5c6,0,9.3-5,9.3-9.3c0-0.1,0-0.3,0-0.4C15,4.3,15.6,3.7,16,3z"></path></g></svg>
            </a>

            <a class="footer-v5__social-btn" href="#0">
              <svg class="icon" viewBox="0 0 16 16"><title>Follow us on Youtube</title><g><path d="M15.8,4.8c-0.2-1.3-0.8-2.2-2.2-2.4C11.4,2,8,2,8,2S4.6,2,2.4,2.4C1,2.6,0.3,3.5,0.2,4.8C0,6.1,0,8,0,8 s0,1.9,0.2,3.2c0.2,1.3,0.8,2.2,2.2,2.4C4.6,14,8,14,8,14s3.4,0,5.6-0.4c1.4-0.3,2-1.1,2.2-2.4C16,9.9,16,8,16,8S16,6.1,15.8,4.8z M6,11V5l5,3L6,11z"></path></g></svg>
            </a>

            <a class="footer-v5__social-btn" href="#0">
              <svg class="icon" viewBox="0 0 16 16"><title>Follow us on Github</title><g><path  d="M8,0.2c-4.4,0-8,3.6-8,8c0,3.5,2.3,6.5,5.5,7.6 C5.9,15.9,6,15.6,6,15.4c0-0.2,0-0.7,0-1.4C3.8,14.5,3.3,13,3.3,13c-0.4-0.9-0.9-1.2-0.9-1.2c-0.7-0.5,0.1-0.5,0.1-0.5 c0.8,0.1,1.2,0.8,1.2,0.8C4.4,13.4,5.6,13,6,12.8c0.1-0.5,0.3-0.9,0.5-1.1c-1.8-0.2-3.6-0.9-3.6-4c0-0.9,0.3-1.6,0.8-2.1 c-0.1-0.2-0.4-1,0.1-2.1c0,0,0.7-0.2,2.2,0.8c0.6-0.2,1.3-0.3,2-0.3c0.7,0,1.4,0.1,2,0.3c1.5-1,2.2-0.8,2.2-0.8 c0.4,1.1,0.2,1.9,0.1,2.1c0.5,0.6,0.8,1.3,0.8,2.1c0,3.1-1.9,3.7-3.7,3.9C9.7,12,10,12.5,10,13.2c0,1.1,0,1.9,0,2.2 c0,0.2,0.1,0.5,0.6,0.4c3.2-1.1,5.5-4.1,5.5-7.6C16,3.8,12.4,0.2,8,0.2z"></path></g></svg>
            </a>
          </div>
        </div>

        <div>
          <p class="text-sm color-contrast-medium flex flex-wrap gap-xs text-xs@md">
            <a class="color-inherit text-underline" href="#0">Terms</a>
            <a class="color-inherit text-underline" href="#0">Privacy</a>
            <a class="color-inherit text-underline" href="#0">Cookies</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>
{{--  Back to Top  --}}
    <a class="back-to-top js-back-to-top" href="#" data-offset="100" data-duration="300">
        <svg class="icon" viewBox="0 0 20 20"><polyline points="2 13 10 5 18 13" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
    </a>
{{--  End Back to Top  --}}
 <script src="{{ asset("js/scripts.js") }}"></script>
 <livewire:scripts />
@stack('js')
      </body>
      </html>
