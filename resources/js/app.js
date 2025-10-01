import './bootstrap';

import { createApp } from 'vue';
import CartIcon from '../views/components/CartIcon.vue';

const app = createApp({});

app.component('cart-icon', CartIcon);


import './cartItemCount';

app.mount('#app');