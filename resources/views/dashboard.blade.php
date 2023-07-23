<?php
$name = Auth::user()->name;
$userId = Auth::id();
$email = Auth::user()->email;
?>
<link rel="icon" href="site_logo.png" type="image/x-icon">
<link rel="stylesheet" href="https://cdn.fontcdn.ir/Font/Persian/Vazir/v5.0.2/Vazir.css" type="text/css" />
<meta name="author" content="آرمان جعفری">
<style>
    *{
        transition: background 0.3s, color 0.3s;
        font-family: 'Vazir', sans-serif;
        font-size: medium;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('میزکار') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="direction: rtl;">
                <div class="p-6 text-gray-900">
                    {{$name}} عزیز، {{ __("شما وارد حسبتان شدید!") }}
                </div>
                <div class="p-6 text-gray-900">
                    آیدی شما " {{$userId}} " میباشد و ایمیل شما " {{$email}} " است                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
