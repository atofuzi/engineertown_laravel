/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//追加
Vue.component('sample-component' , require('./components/SampleComponent.vue').default);

Vue.component('input-text-component' , require('./components/InputTextComponent.vue').default);

Vue.component('textarea-component' , require('./components/TextareaComponent.vue').default);

Vue.component('skills-component' , require('./components/SkillsComponent.vue').default);

Vue.component('input-radio-component' , require('./components/InputRadioComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    el: '#app',
});

new Vue({
    el: '#vue-textarea',
});

new Vue({
    el: '#vue-input-text-1',
});

new Vue({
    el: '#vue-input-text-2',
});

new Vue({
    el: '#vue-skills',
});

new Vue({
    el: '#vue-radio',
});


//???????
new Vue({
    el: "#info",
    data: {
        isActive: "1"
    },
    methods: {
        change: function(num) {
            this.isActive = num;
        }
    }
});
