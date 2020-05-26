<template>
<section>
	<products-actions />
	<products-component :key="user.id" :data-index="index" v-bind:user="user" v-for="(user, index) in users"/>
</section>

  <!-- <products-component  /> -->
  <!-- <h2 :key="product.id" :data-index="index" v-for="(product, index) in products">{{product.username}}
		</h2> -->
</template>

<script>
export default {
	data(){
		 return{
			name: 'user product component',
			users: [],
			endpoint: "/productos/list", //se indica el endpoint
			endpointhome: "/home",
			currentRoute: '',
		}
	},

	// se indica al momento de crear el componente se ejecute la funcion fetchProducts
	created(){
		this.currentRoute = window.currentRoute;
		this.fetchProducts();
	},

	methods: {
		// se crea la funcion ajax para consultar datos
		fetchProducts(){
			// console.log(this.currentRoute)
			//axios es para consultas ajax preconfigurada para laravel
			if(currentRoute == 'home'){
				axios.get(this.endpointhome).then((response)=>{
				// console.log(response.data.data);
				this.users = response.data.data;
				// console.log(this.users)
			});
			} else {
				axios.get(this.endpoint).then((response)=>{
				// console.log(response.data.data);
				this.users = response.data.data;
			});
			}
		},

		isCurrentRoute(routeName) {
			return this.currentRoute === routeName;
			// console.log
		}
	}

}
</script>
