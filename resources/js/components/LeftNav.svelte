<script>
    // import { page } from "$app/stores";

    // $: url = $page.route.id
    // console.log(url)

    import { inertia, page } from "@inertiajs/svelte";

    const navPages = [
        {
            icon: "mdi:patient-outline",
            href: "/dashboard/bitacora",
            name: "Bitácora",
        },
        {
            icon: "mdi:patient-outline",
            href: "/dashboard/maquinas",
            name: "Maquinas",
        },
        {
            icon: "mdi:patient-outline",
            href: "/dashboard/mantenimiento",
            name: "Mantenimiento",
        },
    ];
    console.log($page);
</script>

<nav class="left_nav rounded-tr-xl pt-2 text-white text-opacity-90">
    <ul
        class="flex justify-around items-center h-full md:flex-col
    md:items-start md:justify-normal md:p-2 md:gap-1 md:[&>*]:w-full"
    >
        {#each navPages as navPage}
            <li>
                <a
                    href={navPage.href}
                    use:inertia
                    class="hover:bg-gray-800 z-10 rounded-md flex md:gap-2 items-center p-2"
                    class:active={$page.url.startsWith(navPage.href)}
                    ><iconify-icon
                        class="text-xlc md:text-lg"
                        icon={navPage.icon}
                    /><span class="label_link hidden md:block"
                        >{navPage.name}</span
                    ></a
                >
            </li>
        {/each}
    </ul>
</nav>

<style>
    .active {
        /* background: linear-gradient(80deg, #acd7f2 9%, transparent 99%); */
        position: relative;
        border-radius: 6px;
        /* box-shadow: 0 0 10px 0px #9BF2EA; */
        color: #21262e !important;
        font-weight: bold;
    }
    a:before {
        position: absolute;
        transition: .2s;
        content: "";
        width: 0%;
        left: 0;
        border-radius: 5px;
        z-index: -1;
        height: 100%;
        background: linear-gradient(80deg, #acd7f2 9%, transparent 99%);
        background: #acd7f2;

    }
    a.active:before {
        width: 100%;
        
    }
    a:active {
        background: #0B8CD5;
    }
</style>
