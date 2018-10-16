<template>
	<section class="h-100-vh" id="landing-section" :style="'background: url('+background_data.image+')'">
		<div class="overlay"></div>
		<div class="container-fluid c-height-inherit">
			<div class="row justify-content-center align-items-center h-100">
				<keep-alive>
					<nav-frontend></nav-frontend>
				</keep-alive>
				<div class="col-12 d-flex flex-column text-center align-content-center">
					<div class="w-75 m-auto">
						<h1 class="display-md-2 font-weight-bold">FF</h1>
						<h1 class="display-md-3 font-italic">Football Formations</h1>
						<p>A Fifa like experience creating and managing your teams. Bring a level of professionalism to what ever you chose to create formations for. Whether that be for Sunday league, five-a-side, local tournaments or playing in the virtual world on the most acclaimed football simulator FM (football manager).</p>
            <router-link to="/register">packages quick route</router-link>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>
<script>
import Nav from "./../navigation/Nav.vue";
export default {
  components: {
    "nav-frontend": Nav
  },
  data() {
    return {
      background_data: {
        image: "/src/assets/ben-hershey-603997-unsplash.jpg",
        creator: "Photo by Ben Hershey on Unsplash"
      }
    };
  }
};
</script>
<style lang="scss" scoped>
$primary_green: #42b983;
$secondary_green: #006838;

.overlay {
  position: absolute;
  height: 100vh;
  width: 100%;
  background-color: $primary_green;
  opacity: 0.3;
}

section {
  background-color: #f2f2f2;
  background: url("/src/assets/8177.jpg");
  background-position: center !important;
  background-size: cover !important;
  color: #fff;
}
</style>

