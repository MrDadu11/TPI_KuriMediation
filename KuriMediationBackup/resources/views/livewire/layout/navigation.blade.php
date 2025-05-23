<?php

use App\Models\User;
use App\Models\Meeting;
use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Session;

new class extends Component
{

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/login', navigate: true);
    }

}; ?>

<nav x-data="{ open: false }" class="">
    <!-- Primary Navigation Menu -->
    <div class="bg-gray-100 border-b border-gray-300 md:shadow-2xl md:border md:mt-2 max-w-screen xl:max-w-7xl mx-auto px-4 py-4 md:px-6 xl:px-8 rounded-xl">
        <div class="pt-2 px-2 inline-flex w-full justify-between items-center">            
            <div class="md:flex">
                <!-- Logo -->
                <div class="md:flex items-center">
                    <a href="{{ route('meeting.index') }}" wire:navigate>
                        <span class="text-3xl font-bold text-blue-800">KuriMediation</span>
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden md:my-px md:ms-10 md:flex bg-gray-100 xl:shadow-md">
                    <x-nav-link class="rounded-ss-lg rounded-es-lg" :href="route('meeting.index')" :active="request()->routeIs('meeting.index')" wire:navigate>
                        {{ __('Accueil') }}
                    </x-nav-link>
                    <x-nav-link :href="route('graphic.index')" :active="request()->routeIs('graphic.index')" wire:navigate>
                        {{ __('Graphiques') }}
                    </x-nav-link>
                    <x-nav-link class="rounded-se-lg rounded-ee-lg" :href="route('about')" :active="request()->routeIs('about')" wire:navigate>
                        {{ __('A Propos') }}
                    </x-nav-link>
                    @if (Auth::user()->isAdmin == 1)
                    <div class="bg-gray-300 flex items-center rounded-lg">
                        <a class="p-2 border border-transparent text-md font-bold leading-5 hover:text-white focus:outline-none focus:text-white transition duration-150 ease-in-out rounded-ss-lg rounded-es-lg {{ request()->routeIs('user.index') ? 'bg-blue-800 text-white' : 'bg-gray-300 hover:bg-blue-800 focus:bg-blue-800' }}" href="{{ route('user.index') }}" wire:navigate>
                            {{ __('Utilisateurs') }}
                        </a>
                        <a class="p-2 border border-transparent text-md font-bold leading-5 hover:text-white focus:outline-none focus:text-white transition duration-150 ease-in-out rounded-se-lg rounded-ee-lg {{ request()->routeIs('type.index') ? 'bg-blue-800 text-white' : 'bg-gray-300 hover:bg-blue-800 focus:bg-blue-800' }}" href="{{ route('type.index') }}" wire:navigate>
                            {{ __('Types') }}
                        </a>                                                              
                    </div>
                    @endif
                </div>
            </div>            
            <!-- Settings Dropdown -->
            <div class="hidden md:flex md:items-center md:ms-6">
                <p class="font-bold">{{ auth()->user()->username }}</p>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-3xl md:ml-3">
                            <img class="rounded-3xl" height="50px" width="50px" src="{{ asset(auth()->user()->profile_pic_path) }}" alt="ProfilePicture">
                        </button>
                    </x-slot>
                    
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profil') }}
                        </x-dropdown-link>
                        
                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>
            
            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-3xl">
                    <img class="rounded-3xl" height="50px" width="50px" src="{{ asset(auth()->user()->profile_pic_path)}}" alt="ProfilePicture">
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <div class="pt-2">
            <x-responsive-nav-link :href="route('meeting.index')" :active="request()->routeIs('meeting.index')" wire:navigate>
                {{ __('Accueil') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('graphic.index')" :active="request()->routeIs('graphic.index')" wire:navigate>
                {{ __('Graphiques') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')" wire:navigate>
                {{ __('A Propos') }}
            </x-responsive-nav-link>
            @if (Auth::user()->isAdmin == 1)
            <x-responsive-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')" wire:navigate>
                {{ __('Utilisateurs') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('type.index')" :active="request()->routeIs('type.index')" wire:navigate>
                {{ __('Types') }}
            </x-responsive-nav-link>                     
        @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-2 pb-1 border-t border-black bg-white">
            <div class="space-y-1">
                <div class="px-3 py-2 flex items-center">
                    <span class="font-bold text-2xl text-blue-800 mr-1">Utilisateur :</span>
                    <div class="font-bold text-2xl text-black" x-data="{{ json_encode(['username' => auth()->user()->username]) }}" x-text="username" x-on:profile-updated.window="username = $event.detail.username"></div>
                </div>

                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
