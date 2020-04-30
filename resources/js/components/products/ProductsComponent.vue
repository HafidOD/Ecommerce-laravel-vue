<template>
	<section>
		<material-transition-group tag="div" class="row">
			<product-card-component :key="product.id" :data-index="index" v-bind:product="product" 
			v-for="(product, index) in products" />
		</material-transition-group>
	</section>
</template>

<script>
export default {
	 data(){
		 return{
			name: 'product component',
			products: [],
			endpoint: "/productos" //se indica el endpoint
		}
	},

	// se indica al momento de crear el componente se ejecute la funcion fetchProducts
	created(){
		this.fetchProducts();
	},

	methods: {
		// se crea la funcion ajax para consultar datos
		fetchProducts(){
			//axios es para consultas ajax preconfigurada para laravel
			axios.get(this.endpoint).then((response)=>{
				console.log(response.data.data);
				this.products = response.data.data;
			});
		},

		
	}
}
</script>