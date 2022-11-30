import { createApp, h } from 'vue'
import { InertiaProgress } from '@inertiajs/progress'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import VueGoogleMaps from '@fawmi/vue-google-maps'
import * as mdb from 'mdb-ui-kit'; // lib
import { Input } from 'mdb-ui-kit'; // module

InertiaProgress.init()

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    title: title => title ? `${title} - Ping CRM` : 'Ping CRM',
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(VueGoogleMaps, {
                load: {
                    key: 'AIzaSyASS8XJb5OPvAT4wryPX06UXxvX3Xu2LJo',
                    language: 'en',
                    libraries: "places"

                },
            })
            .mount(el)
    },
})
