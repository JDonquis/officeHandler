<script>
    import { onMount } from "svelte";
    import LeftNav from "./LeftNav.svelte";
    import Header from "./Header.svelte";
    import Footer from "./Footer.svelte";
	import 'iconify-icon';
	import { navStatus } from '../stores/navStatus';
    import { element } from "svelte/internal";
    let screenWidth=  window.innerWidth 
    // $: mainWidth = main.offsetWidth;
    let mainWidth = `width:${screenWidth}%`
    $: if (screenWidth > 768) {
        mainWidth =`width:${screenWidth - $navStatus.navWidth-20}px`
    }
    
</script>

<svelte:head>

</svelte:head>
<section class="bg-white min-h-screen  dashboard_container" class:menuStatus-false={$navStatus.isContracted}>
    <Header />

    <div class=" main_and_footer_container  border-l border-gray-700" bing:this="main_and_footer_container">
        <main  style={mainWidth}  class={`mx-auto main_dashboard   relative px-10 duration-100 pb-10`} >
            <slot />
        </main>
        <Footer />

    </div>
    <LeftNav />
</section>
