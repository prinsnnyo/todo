import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import TodoList from './Components/TodoList.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Create the main application instance
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({
            render: () => h(App, props)
        });

        // Use the Inertia plugin and Ziggy for routing
        app.use(plugin);
        app.use(ZiggyVue);

        // Register your global component
        app.component('TodoList', TodoList);

        // Mount the application to the specified element
        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});