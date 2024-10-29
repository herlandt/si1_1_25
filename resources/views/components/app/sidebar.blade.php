<div>
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 p-4 transition-all duration-200 ease-in-out"
        :class="{ 'bg-cyan-900 dark:bg-slate-800': true, 'translate-x-0': sidebarOpen, '-translate-x-64': !sidebarOpen }"
        @click.outside="sidebarOpen = false" @keydown.escape.window="sidebarOpen = false" x-cloak="lg">

        <!-- Sidebar header -->
        <div class="flex justify-between mb-3 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>

        </div>

        <!-- Links -->
        <div class="space-y-3">
            <!-- Pages group -->
            <div>
                <h3 class="text-xs text-center uppercase text-slate-100 font-semibold pl-3">

                    <span class="hidden lg:block lg:sidebar-expanded:hidden 4x2:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">TIENDA WEB INFORMATICA</span>
                </h3>
                <ul class="mt-3">
                    @hasanyrole('ejecutivo|general|secretario')
                    <li
                        class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['dashboard'])) {{ 'from-violet-100/[0.12] dark:from-violet-100/[0.24] to-violet-100/[0.04]' }} @endif">
                        <a class="block text-gray-100 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['dashboard'])) {{ 'hover:text-orange-400 dark:hover:text-orange-400' }} @endif"
                            href="{{ route('dashboard') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['dashboard'])) {{ 'text-orange-400' }}@else{{ 'text-gray-200 dark:text-gray-200' }} @endif"
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 22 22">
                                    <path fill="currentColor"
                                        d="M4 19v2c0 .5523.44772 1 1 1h14c.5523 0 1-.4477 1-1v-2H4Z" />
                                        <path fill-rule="evenodd" d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" clip-rule="evenodd"/>
                                </svg>



                                <span
                                    class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                            </div>
                        </a>
                    </li>
                    @endhasanyrole
                    <li
                        class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['cajas'])) {{ 'from-violet-100/[0.12] dark:from-violet-100/[0.24] to-violet-100/[0.04]' }} @endif">
                        <a class="block text-gray-100 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['cajas'])) {{ 'hover:text-orange-400 dark:hover:text-orange-400' }} @endif"
                            href="{{ route('cajas.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['cajas'])) {{ 'text-orange-400' }}@else{{ 'text-gray-200 dark:text-gray-200' }} @endif"
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 22 22">
                                    <path fill="currentColor"
                                        d="M4 19v2c0 .5523.44772 1 1 1h14c.5523 0 1-.4477 1-1v-2H4Z" />
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M9 3c0-.55228.44772-1 1-1h8c.5523 0 1 .44772 1 1v3c0 .55228-.4477 1-1 1h-2v1h2c.5096 0 .9376.38314.9939.88957L19.8951 17H4.10498l.90116-8.11043C5.06241 8.38314 5.49047 8 6.00002 8H12V7h-2c-.55228 0-1-.44772-1-1V3Zm1.01 8H8.00002v2.01H10.01V11Zm.99 0h2.01v2.01H11V11Zm5.01 0H14v2.01h2.01V11Zm-8.00998 3H10.01v2.01H8.00002V14ZM13.01 14H11v2.01h2.01V14Zm.99 0h2.01v2.01H14V14ZM11 4h6v1h-6V4Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <span
                                    class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Caja</span>
                            </div>
                        </a>
                    </li>
                    <li
                        class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['productos'])) {{ 'from-violet-100/[0.12] dark:from-violet-100/[0.24] to-violet-100/[0.04]' }} @endif">
                        <a class="block text-gray-100 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['productos'])) {{ 'hover:text-orange-400 dark:hover:text-orange-400' }} @endif"
                            href="{{ route('productos.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['productos'])) {{ 'text-orange-400' }}@else{{ 'text-gray-200 dark:text-gray-200' }} @endif"
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 22 22">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                        d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5" />
                                </svg>

                                <span
                                    class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Productos</span>
                            </div>
                        </a>
                    </li>
                    <li
                        class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['ventas'])) {{ 'from-violet-100/[0.12] dark:from-violet-100/[0.24] to-violet-100/[0.04]' }} @endif">
                        <a class="block text-gray-100 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['ventas'])) {{ 'hover:text-orange-400 dark:hover:text-orange-400' }} @endif"
                            href="{{ route('ventas.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['ventas'])) {{ 'text-orange-400' }}@else{{ 'text-gray-200 dark:text-gray-200' }} @endif"
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 22 22">
                                    <path fill-rule="evenodd"
                                        d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <span
                                    class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Ventas</span>
                            </div>
                        </a>
                    </li>

                    <li
                        class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['notas'])) {{ 'from-violet-100/[0.12] dark:from-violet-100/[0.24] to-violet-100/[0.04]' }} @endif">
                        <a class="block text-gray-100 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['notas'])) {{ 'hover:text-orange-400 dark:hover:text-orange-400' }} @endif"
                            href="{{ route('notas.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['notas'])) {{ 'text-orange-400' }}@else{{ 'text-gray-200 dark:text-gray-200' }} @endif"
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 22 22">
                                    <path fill-rule="evenodd"
                                        d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-3 8a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H9Zm2 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H9Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <span
                                    class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Reporte
                                    de Ventas</span>
                            </div>
                        </a>
                    </li>

                    <li
                        class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['impresiones'])) {{ 'from-violet-100/[0.12] dark:from-violet-100/[0.24] to-violet-100/[0.04]' }} @endif">
                        <a class="block text-gray-100 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['impresiones'])) {{ 'hover:text-orange-400 dark:hover:text-orange-400' }} @endif"
                            href="{{ route('impresiones.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['cajas'])) {{ 'text-orange-400' }}@else{{ 'text-gray-200 dark:text-gray-200' }} @endif"
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 22 22">
                                    <path fill="currentColor"
                                        d="M4 19v2c0 .5523.44772 1 1 1h14c.5523 0 1-.4477 1-1v-2H4Z" />
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M9 3c0-.55228.44772-1 1-1h8c.5523 0 1 .44772 1 1v3c0 .55228-.4477 1-1 1h-2v1h2c.5096 0 .9376.38314.9939.88957L19.8951 17H4.10498l.90116-8.11043C5.06241 8.38314 5.49047 8 6.00002 8H12V7h-2c-.55228 0-1-.44772-1-1V3Zm1.01 8H8.00002v2.01H10.01V11Zm.99 0h2.01v2.01H11V11Zm5.01 0H14v2.01h2.01V11Zm-8.00998 3H10.01v2.01H8.00002V14ZM13.01 14H11v2.01h2.01V14Zm.99 0h2.01v2.01H14V14ZM11 4h6v1h-6V4Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <span
                                    class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Impresiones</span>
                            </div>
                        </a>
                    </li>
                    
                    @hasanyrole('ejecutivo|general|secretario')
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['compras'])) {{ 'from-violet-100/[0.12] dark:from-violet-100/[0.24] to-violet-100/[0.04]' }} @endif">
                            <a class="block text-gray-100 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['compras'])) {{ 'hover:text-orange-400 dark:hover:text-orange-400' }} @endif"
                                href="{{ route('compras.index') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['compras'])) {{ 'text-orange-400' }}@else{{ 'text-gray-200 dark:text-gray-200' }} @endif"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 22 22">
                                        <path fill-rule="evenodd"
                                            d="M11 16.5a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0Zm4.5 2.5v-1.5H14v-2h1.5V14h2v1.5H19v2h-1.5V19h-2Z"
                                            clip-rule="evenodd" />
                                        <path
                                            d="M3.987 4A2 2 0 0 0 2 6v9a2 2 0 0 0 2 2h5v-2H4v-5h16V6a2 2 0 0 0-2-2H3.987Z" />
                                        <path fill-rule="evenodd" d="M5 12a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Z"
                                            clip-rule="evenodd" />
                                    </svg>

                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Compras</span>
                                </div>
                            </a>
                        </li>
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['gastos'])) {{ 'from-violet-100/[0.12] dark:from-violet-100/[0.24] to-violet-100/[0.04]' }} @endif">
                            <a class="block text-gray-100 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['gastos'])) {{ 'hover:text-orange-400 dark:hover:text-orange-400' }} @endif"
                                href="{{ route('gastos.index') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['gastos'])) {{ 'text-orange-400' }}@else{{ 'text-gray-200 dark:text-gray-200' }} @endif"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 22 22">
                                        <path fill-rule="evenodd"
                                            d="M7 6a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-2v-4a3 3 0 0 0-3-3H7V6Z"
                                            clip-rule="evenodd" />
                                        <path fill-rule="evenodd"
                                            d="M2 11a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7Zm7.5 1a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5Z"
                                            clip-rule="evenodd" />
                                        <path d="M10.5 14.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" />
                                    </svg>

                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Gastos</span>
                                </div>
                            </a>
                        </li>
                    @endhasanyrole
                    @hasanyrole('ejecutivo')
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['usuarios'])) {{ 'from-violet-100/[0.12] dark:from-violet-100/[0.24] to-violet-100/[0.04]' }} @endif">
                            <a class="block text-gray-100 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['usuarios'])) {{ 'hover:text-orange-400 dark:hover:text-orange-400' }} @endif"
                                href="{{ route('usuarios.index') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['usuarios'])) {{ 'text-orange-400' }}@else{{ 'text-gray-200 dark:text-gray-200' }} @endif"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 22 22">
                                        <path fill-rule="evenodd"
                                            d="M9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H7Zm8-1a1 1 0 0 1 1-1h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 0 1-1-1Z"
                                            clip-rule="evenodd" />
                                    </svg>


                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Usuarios</span>
                                </div>
                            </a>
                        </li>
                    @endhasanyrole
                    @hasanyrole('ejecutivo')
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['clientes'])) {{ 'from-violet-100/[0.12] dark:from-violet-100/[0.24] to-violet-100/[0.04]' }} @endif">
                            <a class="block text-gray-100 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['clientes'])) {{ 'hover:text-orange-400 dark:hover:text-orange-400' }} @endif"
                                href="{{ route('clientes.index') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['clientes'])) {{ 'text-orange-400' }}@else{{ 'text-gray-200 dark:text-gray-200' }} @endif"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 22 22">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                            d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                    </svg>

                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Clientes</span>
                                </div>
                            </a>
                        </li>
                    @endhasanyrole
                    @hasanyrole('ejecutivo')
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['bitacora'])) {{ 'from-violet-100/[0.12] dark:from-violet-100/[0.24] to-violet-100/[0.04]' }} @endif">
                            <a class="block text-gray-100 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['bitacora'])) {{ 'hover:text-orange-400 dark:hover:text-orange-400' }} @endif"
                                href="{{ route('bitacora.index') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['bitacora'])) {{ 'text-orange-400' }}@else{{ 'text-gray-200 dark:text-gray-200' }} @endif"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 22 22">
                                        <path fill-rule="evenodd"
                                            d="M10 2a3 3 0 0 0-3 3v1H5a3 3 0 0 0-3 3v2.382l1.447.723.005.003.027.013.12.056c.108.05.272.123.486.212.429.177 1.056.416 1.834.655C7.481 13.524 9.63 14 12 14c2.372 0 4.52-.475 6.08-.956.78-.24 1.406-.478 1.835-.655a14.028 14.028 0 0 0 .606-.268l.027-.013.005-.002L22 11.381V9a3 3 0 0 0-3-3h-2V5a3 3 0 0 0-3-3h-4Zm5 4V5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1h6Zm6.447 7.894.553-.276V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-5.382l.553.276.002.002.004.002.013.006.041.02.151.07c.13.06.318.144.557.242.478.198 1.163.46 2.01.72C7.019 15.476 9.37 16 12 16c2.628 0 4.98-.525 6.67-1.044a22.95 22.95 0 0 0 2.01-.72 15.994 15.994 0 0 0 .707-.312l.041-.02.013-.006.004-.002.001-.001-.431-.866.432.865ZM12 10a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                                            clip-rule="evenodd" />
                                    </svg>


                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Bitacora</span>
                                </div>
                            </a>
                        </li>
                    @endhasanyrole


                </ul>
            </div>

        </div>

        <!-- Expand / collapse button -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="px-3 py-2">
                <button @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                        <path class="text-slate-400"
                            d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                        <path class="text-slate-600" d="M3 23H1V1h2z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>
