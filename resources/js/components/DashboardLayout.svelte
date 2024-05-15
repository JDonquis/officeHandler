<script>
    import LeftNav from "./LeftNav.svelte";
    import Header from "./Header.svelte";
    import Footer from "./Footer.svelte";
	import 'iconify-icon';

</script>

<svelte:head>

</svelte:head>

<section class="bg-white min-h-screen dashboard_container">
    <Header />

    <div class=" main_and_footer_container border-l dark:border-gray-700">
        <main class="px-20 pt-10">
            <slot />
        </main>

        <Footer />
    </div>
    <LeftNav />
</section>
