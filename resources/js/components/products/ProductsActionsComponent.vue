<template>
  <div class="mb-4">
	  <div class="text-right">
		  <a href="/productos/create" type="button" class="btn btn-primary">Agregar producto</a>
	  </div>
	  <hr />
  </div>
</template>

<script>
	import bootstrap from 'bootstrap';
  export default {
    name: 'ProductsActionsComponent',
	  mounted() {
    	console.log(bootstrap)
	  }
  };
</script>

<style>

</style>
