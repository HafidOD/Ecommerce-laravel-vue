<template>
	<section>
		<material-transition-group tag="div" class="row">
			<product-card-component :key="product.id" :data-index="index" v-bind:product="product"
			v-for="(product, index) in user.products"
			:username="user.username" />

		</material-transition-group>
	</section>
</template>

<script>
export default {
	props:{
        user:{
            type: Object
        }
	}
}
</script>
