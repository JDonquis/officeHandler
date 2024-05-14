<script>
    import LeftNav from "./LeftNav.svelte";
    import Header from "./Header.svelte";
    import Footer from "./Footer.svelte";
	// import 'iconify-icon';

</script>

<svelte:head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
</svelte:head>

<section class="bg-white min-h-screen dashboard_container">
    <Header />

    <div class=" main_and_footer_container border-l dark:border-gray-700">
        <main class="px-10 ">
            <slot />
        </main>

        <Footer />
    </div>
    <LeftNav />
</section>
