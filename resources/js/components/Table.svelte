<script>
    import { inertia } from "@inertiajs/svelte";
    import { router } from "@inertiajs/svelte";
    import {page } from "@inertiajs/svelte";
    import debounce from "lodash/debounce";
    import { createEventDispatcher } from "svelte";

    $: console.log($page.url)
    // $: console.log($page)
    const dispatch = createEventDispatcher();

    export let filtersOptions = false;
    export let selectedRow;
    export let serverSideData = {};
    $: console.log(filtersOptions);
    $: console.log(serverSideData.filters);

    let filterClientData = {
        ...serverSideData.filters
    }
    // $: $form, handleFilters()
    // console.log(serverSideData.filters.search);


    const handleFilters = debounce((event) => {
        console.log("activando");
        router.get(`${$page.url}`, filterClientData);
    }, 300);
    $: console.log(selectedRow);
   

</script>

<section class="w-full">
    <div class="mt-6 md:flex md:items-center md:justify-between">
        <div
            class="inline-flex overflow-hidden  border divide-x rounded-lg bg-gray-900 rtl:flex-row-reverse border-gray-700 divide-gray-700"
        >
            <button on:click={(e) => {
                filterClientData['status'] = ""
                handleFilters()
            }} 
                            class={`px-5 py-2 text-xs font-medium transition-colors duration-200 sm:text-sm   hover:bg-gray-700 ${filterClientData['status'] == '' || !filterClientData['status']? 'bg-gray-800 text-gray-100' : 'text-gray-400'}`}

               

            >
                Todos
            </button>
            {#if filtersOptions}

                {#each Object.entries(filtersOptions) as [filterKey, filterOption]}
                    {#each filterOption as filter}
                        <button on:click={(e) => {
                            filterClientData[filterKey] = filter.id
                            handleFilters()
                        }} 
                            class={`px-5 py-2 text-xs font-medium transition-colors duration-200 sm:text-sm   hover:bg-gray-700 ${filterClientData[filterKey] == filter.id ? 'bg-gray-800 text-gray-100' : 'text-gray-400'}`}
                           
                        >
                            {filter.name}
                        </button>
                    {/each}
                {/each}
            {/if}
        </div>

        <div class="relative flex items-center mt-4 md:mt-0">
            <span class="absolute">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5 mx-3  text-gray-600"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                    />
                </svg>
            </span>

            <input
                type="search"
                placeholder="Buscar"
                bind:value={filterClientData.search}
                on:input={() => {
                    handleFilters();
                }}
                class="block w-full py-1.5 pr-5  border  rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 bg-gray-900 text-gray-300 border-gray-600 focus:border-blue-400 focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
            />
        </div>
        {#if selectedRow.status}
            <div class="flex gap-5 relative items-end">
                <slot name="selectedButtons" />
                <button
                    on:click={() => dispatch("fillFormToEdit")}
                    class="bg-color3 bg-opacity-10 hover:bg-opacity-20 cursor-pointer text-2xl rounded border border-color3 px-4 py-1"
                    title="Editar"
                >
                    <iconify-icon class="relative -bottom-1" icon="line-md:edit"
                    ></iconify-icon>
                </button>

                <button
                    on:click={() => dispatch("clickDeleteIcon")}
                    class="bg-red bg-opacity-10 hover:bg-opacity-20 cursor-pointer text-2xl rounded border border-red px-4 py-1"
                    title="Eliminar"
                >
                    <iconify-icon
                        class="relative -bottom-1"
                        icon="material-symbols:delete-outline"
                    ></iconify-icon>
                </button>
            </div>
        {/if}
    </div>

    <div class="flex flex-col mt-4">
        <div
            class="-mx-4 -my-2 overflow-x-auto overflow-y-visible sm:-mx-6 lg:-mx-8"
        >
            <div class="inline-block w-full py-2 align-middle md:px-6 lg:px-8">
                <div
                    class="overflow-x-auto max-h-[500px] overflow-y-auto scroll-table border  border-gray-700 md:rounded-lg"
                >
                    <table
                        class="table overflow-scroll overflow-y-auto w-full divide-y  divide-gray-700"
                    >
                        <slot name="thead"></slot>

                        <slot
                            name="tbody"
                            class="divide-y  divide-gray-700 bg-gray-900"
                        ></slot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-2 sm:flex sm:items-center sm:justify-between">
        <div class="text-sm  text-gray-400">
            Página <span class="font-medium  text-gray-100"
                >{serverSideData.current_page} de {serverSideData.last_page}</span
            >
            |
            <span class="text-gray-500">Desde {serverSideData.from} hasta {serverSideData.to} de {serverSideData.total}</span>
        </div>

        <div class="flex items-center mt-4 gap-x-4 sm:mt-0 ">
            <a
                use:inertia
                href={serverSideData.prev_page_url}
                class={`flex items-center justify-center w-1/2 px-5 py-2 text-sm  capitalize transition-colors duration-200 disabled:cursor-not-allowed  border rounded-md sm:w-auto gap-x-2  bg-gray-900  border-gray-700 hover:bg-gray-800 ${!serverSideData.prev_page_url ? 'text-gray-500 border-gray-700 ': 'text-gray-200 border-gray-600'}`}
                disabled={serverSideData.prev_page_url == null}
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5 rtl:-scale-x-100"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18"
                    />
                </svg>

                <span> previous </span>
            </a>

            <a
                use:inertia
                href={serverSideData.next_page_url}
                class={`flex items-center justify-center w-1/2 px-5 py-2 text-sm  capitalize transition-colors duration-200   border rounded-md sm:w-auto gap-x-2  bg-gray-900  hover:bg-gray-800 ${!serverSideData.next_page_url ?  'text-gray-500 border-gray-700 ': 'text-gray-200 border-gray-600'}`}
                disabled={serverSideData.next_page_url == null}
            >
                <span> Next </span>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5 rtl:-scale-x-100"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"
                    />
                </svg>
            </a>
        </div>
    </div>
</section>

<style>
    /* normal css */
    .scroll-table::-webkit-scrollbar {
        /* width: 17px;   */
        height: 13px;
    }

    .scroll-table::-webkit-scrollbar-track {
        background: rgb(14, 14, 14); /* color of the tracking area */
        /* padding: 2px; */
    }

    .scroll-table::-webkit-scrollbar-thumb {
        background-color: #35475c; /* color of the scroll thumb */
        border-radius: 4px; /* roundness of the scroll thumb */
        border: 3px solid rgb(14, 14, 14);
        border-bottom: 0.2px solid rgb(14, 14, 14);
    }
    .scroll-table::-webkit-scrollbar-thumb:hover {
        background-color: rgb(184, 206, 231);
    }
    .scroll-table::-webkit-scrollbar-corner {
        background: rgba(0, 0, 0, 0.5);
    }
</style>
