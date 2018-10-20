<template>
	<div class="front-end-inner inner-wrapper-div">
		<landing-component></landing-component>
		<features-component></features-component>
		<pricing-component></pricing-component>
	</div>
</template>
<script>
import Landingcomponent from "./homepagecomponents/Landingpage.vue";
import Featurescomponent from "./homepagecomponents/Features";
import Pricingcomponent from "./homepagecomponents/Pricing.vue";

export default {
  components: {
    "landing-component": Landingcomponent,
    "features-component": Featurescomponent,
    "pricing-component": Pricingcomponent
  }
};
</script>
<style lang="scss" scoped>
.b-red {
  border: 1px solid red;
}
</style>
