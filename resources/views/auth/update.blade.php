@extends('layouts.front')

@php
    $user = Auth::user();
@endphp

@section('content')
    <!-- ====== Banner Section Start -->
    <div
        class="
        relative
        z-10
        pt-[120px]
        md:pt-[130px]
        lg:pt-[160px]
        pb-[100px]
        bg-primary
        overflow-hidden
      ">
        <div class="container">
            <div class="flex flex-wrap items-center -mx-4">
                <div class="w-full px-4">
                    <div class="text-center">
                        <h1 class="font-semibold text-white text-4xl">{{ $user->lastname }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <span class="absolute top-0 left-0 z-[-1]">
                <svg width="495" height="470" viewBox="0 0 495 470" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="55" cy="442" r="138" stroke="white" stroke-opacity="0.04"
                        stroke-width="50" />
                    <circle cx="446" r="39" stroke="white" stroke-opacity="0.04" stroke-width="20" />
                    <path d="M245.406 137.609L233.985 94.9852L276.609 106.406L245.406 137.609Z" stroke="white"
                        stroke-opacity="0.08" stroke-width="12" />
                </svg>
            </span>
            <span class="absolute top-0 right-0 z-[-1]">
                <svg width="493" height="470" viewBox="0 0 493 470" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="462" cy="5" r="138" stroke="white" stroke-opacity="0.04"
                        stroke-width="50" />
                    <circle cx="49" cy="470" r="39" stroke="white" stroke-opacity="0.04"
                        stroke-width="20" />
                    <path d="M222.393 226.701L272.808 213.192L259.299 263.607L222.393 226.701Z" stroke="white"
                        stroke-opacity="0.06" stroke-width="13" />
                </svg>
            </span>
        </div>
    </div>
    <!-- ====== Banner Section End -->

    <!-- ====== About Section Start -->
    <section id="about" class="pt-5 lg:pt-[120px] pb-20 lg:pb-[120px] bg-[#f3f4fe]">
        <div class="container">
            <div class="container mx-auto my-5 p-5 flex justify-center">
                @include('layouts.flash')
                <br>
                <div class="px-6 w-full lg:w-9/12 xl:w-9/12">
                    <div class="
                        shadow-testimonial
                        rounded-lg
                        bg-white
                        py-10
                        px-8
                        m-25
                        md:p-[60px]
                        lg:p-10
                        2xl:p-[60px]
                        sm:py-12 sm:px-10
                        lg:py-12 lg:px-10
                        wow
                        fadeInUp
                      "
                        data-wow-delay=".2s">
                        <h3 class="font-semibold mb-8 text-2xl md:text-[26px]">
                            Mettre à jour le Profil
                        </h3>
                        <form method="POST" action="{{ url('user/' . $user->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-6">
                                <label for="picture" class="block text-xs text-dark">Photo de Profil</label>
                                <input type="file" name="picture" value="{{ $user->picture }}"
                                    class="
                              w-full
                              border-0 border-b border-[#f1f1f1]
                              focus:border-primary focus:outline-none
                              py-4
                            "
                                    required />
                            </div>
                            <div class="mb-6">
                                <label for="lastname" class="block text-xs text-dark">Nom</label>
                                <input type="text" name="lastname" value="{{ $user->lastname }}"
                                    class="
                              w-full
                              border-0 border-b border-[#f1f1f1]
                              focus:border-primary focus:outline-none
                              py-4
                            "
                                    required />
                            </div>
                            <div class="mb-6">
                                <label for="firstname" class="block text-xs text-dark">Prénom</label>
                                <input type="text" name="firstname" value="{{ $user->firstname }}"
                                    class="
                              w-full
                              border-0 border-b border-[#f1f1f1]
                              focus:border-primary focus:outline-none
                              py-4
                            "
                                    required />
                            </div>
                            <div class="mb-6">
                                <label for="email" class="block text-xs text-dark">Email</label>
                                <input type="email" name="email" value="{{ $user->email }}" required
                                    class="
                              w-full
                              border-0 border-b border-[#f1f1f1]
                              focus:border-primary focus:outline-none
                              py-4
                            " />
                            </div>
                            <div class="mb-6">
                                <label for="phone" class="block text-xs text-dark">Téléphone</label>
                                <input type="text" name="phone" value="{{ $user->phone }}" required
                                    class="
                              w-full
                              border-0 border-b border-[#f1f1f1]
                              focus:border-primary focus:outline-none
                              py-4
                            " />
                            </div>
                            <div class="mb-6">
                                <label for="adress" class="block text-xs text-dark">Adresse</label>
                                <input type="text" name="adress" value="{{ $user->adress }}"
                                    class="
                              w-full
                              border-0 border-b border-[#f1f1f1]
                              focus:border-primary focus:outline-none
                              py-4
                            " />
                            </div>

                            <div class="mb-6">
                                <label for="birthday" class="block text-xs text-dark">Date de Naissance</label>
                                <input type="date" name="birthday" value="{{ $user->birthday }}"
                                    class="
                              w-full
                              border-0 border-b border-[#f1f1f1]
                              focus:border-primary focus:outline-none
                              py-4
                            " />
                            </div>

                            <div class="mb-6">
                                <label for="birthplace" class="block text-xs text-dark">Lieu de Naissance</label>
                                <input type="text" name="birthplace" value="{{ $user->birthplace }}"
                                    class="
                              w-full
                              border-0 border-b border-[#f1f1f1]
                              focus:border-primary focus:outline-none
                              py-4
                            " />
                            </div>

                            <div class="mb-6">
                                <label for="gender" class="block text-xs text-dark">Sexe</label>
                                <select name="gender"
                                    class="
                                        w-full
                                        border-0 border-b border-[#f1f1f1]
                                        focus:border-primary focus:outline-none
                                        py-4
                                        ">
                                    <option value="H">Homme</option>
                                    <option value="F">Femme</option>
                                </select>
                            </div>



                            <div class="mb-0 flex justify-center">
                                <button
                                    class="
                                        w-2/5
                                        text-center
                                        h-[50px]
                                        text-sm
                                        font-medium
                                        text-white
                                        rounded
                                        mb-6
                                        bg-[#13C296]
                                        cursor-pointer
                                        hover:shadow-lg hover:bg-opacity-90
                                        transition
                                        duration-300
                                        ease-in-out
                                    "
                                    type="submit">
                                    Valider
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ====== About Section End -->
@endsection
