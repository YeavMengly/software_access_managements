@extends('layouts.master')

@section('content')
    <main class="flex items-center justify-center min-h-screen bg-white px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center">
            <p class="text-base font-semibold text-indigo-600">404</p>
            <h1 class="mt-4 text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl">
                Page not found
            </h1>
            <p class="mt-6 text-base leading-7 text-gray-600">Sorry, we couldn’t find the page you’re looking for.</p>
            <div class="mt-10">
                <a href="{{ url('/') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                    ← Back to home
                </a>
            </div>
        </div>
    </main>
@endsection
