<template>
	<ul class="navbar-nav mr-auto">
		<template v-for="(section, index) in sections">
			<li class="nav-item" :class="{'active': isCurrentRoute(section.route)}" :key="index">
				<a class="nav-link" :href="section.link">{{ section.name }}
					<span class="sr-only" v-if="isCurrentRoute(section.route)">(current)</span>
				</a>
			</li>
		</template>
	</ul>
</template>

<script>
  export default {
    name: 'NavbarSections',
	  data() {
    	return {
    		sections: [
			    {
			    	name: 'Inicio',
				    route: 'home',
				    link: '/home'
			    },
			    {
			    	name: 'Mis Productos',
				    route: 'productos.index',
				    link: '/productos'
			    }
		    ],
		    currentRoute: '',
	    };
	  },
	  mounted() {
		  this.currentRoute = window.currentRoute;//.split('.')[0];

		  console.log(this.currentRoute);
	  },
	  methods: {
    	isCurrentRoute(routeName) {
    		return this.currentRoute === routeName;
		  }
	  }
  };
</script>
