<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 shadow-sm">
    <!-- Primary Navigation Menu (Alargado para aproveitar melhor o monitor) -->
    <div class="max-w-[96%] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> <!-- Aumentei ligeiramente a altura da barra para h-20 -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center pr-12">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('magesor.png') }}" alt="Magesor" class="h-14 w-auto object-contain">
                    </a>
                </div>

                <!-- Navigation Links (Com letras maiores para monitores grandes) -->
                <div class="hidden space-x-10 sm:-my-px sm:ml-12 sm:flex sm:items-center">
                    <!-- Link Gestão de Máquinas -->
                    <a href="{{ route('machines.index') }}"
                       class="font-bold transition-all duration-300 hover:scale-105 {{ request()->routeIs('machines.*') ? 'text-4xl text-slate-900' : 'text-lg text-slate-400 hover:text-slate-600' }}">
                        {{ __('Gestão de Máquinas') }}
                    </a>

                    <!-- Link Manutenção / OTs -->
                    <a href="{{ route('work_order.index') }}"
                       class="font-bold transition-all duration-300 hover:scale-105 {{ request()->routeIs('work_order.*') ? 'text-3xl text-yellow-600' : 'text-lg text-slate-400 hover:text-slate-600' }}">
                        {{ __('Manutenção / OTs') }}
                    </a>
            <!-- Restante código (Avarias, Dropdown do utilizador, etc.) -->
            ...

    <!-- COMPONENTE QUICK AVARIA NO TOPO -->
    <div class="ml-4">
        <x-quick-avaria />
    </div>
</div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="38">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-base leading-4 font-medium rounded-md text-slate-500 bg-white hover:text-black focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}<span class="text-sm text-black font-normal"> -  {{ ucfirst(Auth::user()->role) }} </span></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-black hover:bg-slate-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('machines.index')" :active="request()->routeIs('machines.*')">
                {{ __('Parque de Máquinas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('work_order.index')" :active="request()->routeIs('work-order.*')">
                {{ __('Manutenção / OTs') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-slate-200">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
