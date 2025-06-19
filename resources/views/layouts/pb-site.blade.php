<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Student Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="SoonX - Coming Soon Tailwind CSS 3 HTML Template is a multi purpose landing page template built for any Count Down Web Page, Coming Soon Page, Launching Web, Launching Product Website, agency or business Startup. It’s fully responsive and built Tailwind v3" name="description" />
    <meta content="Getappui" name="author" />

    <!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/new_login/img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@200;300;400;500;600;700&display=swap" rel="stylesheet" />
    <!-- Tailwind css Cdn -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="public/landing/js/tailwind.config.js"></script>

</head>

<body class="font-body">

    <section class="lg:h-screen flex items-center justify-center lg:py-32 py-20 relative">
        <div class="overflow-hidden">
            <img class="absolute inset-0 h-full w-full object-cover bg-cover bg-bottom" src="public/landing/img/img.jpg" alt="build your website image">
            <div class="absolute inset-0 bg-black/20"></div>
        </div>

        <div class="container">
            <div class="w-full h-full relative inline-block bg-neutral-900/5 backdrop-blur-2xl">
                <div class="grid lg:grid-cols-2 items-center">
                    <div class="relative">
                        <img src="public/landing/img/img.jpg" alt="" class="w-full h-full">
                        <div class="absolute inset-0 bg-black/60"></div>
                    </div>

        <div class="text-center text-white">
            <div class="p-5">
                <div class="max-w-lg mx-auto">
                    <a href="{{url('/')}}" class="fxt-logo">
                        <img src="{{ asset('public/new_login/img/logo.png') }}" width="150" alt="Logo" class="mx-auto block">
                    </a>
                    <p class="text-white/70 mt-10">
                        Spectrum Film School's High-End student management technology powered by AI taking student management to the next level in Nairobi, Kenya, East Africa, and Africa at large!
                    </p>
                </div>
                <div class="flex items-center shadow-lg rounded-full max-w-xs mx-auto mt-10 gap-x-3">
                    <button class="py-3 w-full rounded-md border border-white/60 text-white font-semibold text-sm hover:bg-black hover:border-black transition-all duration-500">
                        <a href="{{ url('/dashboard') }}"><span>Student Login</span></a>
                    </button>
                    <button class="py-3 w-full rounded-md border border-white/60 text-white font-semibold text-sm hover:bg-black hover:border-black transition-all duration-500">
                        <a href="{{ url('/dashboard') }}"><span>Parent Login</span></a>
                    </button>
                </div>
            </div>
        </div>
    </section>

</html>