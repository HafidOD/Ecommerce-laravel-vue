<template>
	<li class="nav-item" :class="{'active': IsActive}">
		<a class="nav-link" href="/carrito">
			<img src="https://img.icons8.com/bubbles/35/000000/buy.png"/>
			Mi carrito: {{productsCount}}
			<span class="sr-only" v-if="IsActive">(current)</span>
		</a>
	</li>
</template>

<script>
export default {
    props: ["count"],

    created(){
        window.store.commit("set", this.count);
    },

    computed: {
        productsCount(){
            return window.store.state.productsCount; //obtener valor del vuex
        },
        IsActive() {
        	return window.currentRoute === 'shopping-cart.show';
        }
    }
}
</script>
