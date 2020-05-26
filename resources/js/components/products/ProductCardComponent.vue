<template>
<div class="col-xs-12 col-sm-10 col-md-4">
				<div class="card">
					<header class="bg-primary padding">

                    </header>
				<div class="card-body padding">
          <img class="imgcard mx-auto" :src="'/images/'+product.image_url" :alt="product.image_url">
					<h2 class="card-title">
						<a :href="'/productos/'+product.id">{{product.title}}</a>
					</h2>
					<h4 class="card-subtitle">${{product.price / 100}}</h4>
					<p class="card-text">{{product.description}}</p>
					<p>Vendido por: {{username}} </p>
				</div>
				</div>
			</div>
</template>

<script>
export default {
    props:{
		username: String,
        product:{
            type: Object
        }
    }

}
</script>
