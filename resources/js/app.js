import { createInertiaApp } from "@inertiajs/svelte";
import Layout from "./components/DashboardLayout.svelte";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.svelte", { eager: true });
        let page = pages[`./Pages/${name}.svelte`];
        return {
            default: page.default,
            layout: name.startsWith("dashboard/") || name.startsWith("dashboard")  ? undefined : Layout,
        };
        return page;
    },
    setup({ el, App, props }) {
        new App({ target: el, props });
    },
});
