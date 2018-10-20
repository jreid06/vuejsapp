<template>
  <div class="wrapper main-wrapper-container">
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: "app",
  data() {
    return {
      msg: "Welcome to Your Vue.js App"
    };
  }
};
</script>

<style lang="scss">
$primary_green: #42b983;
$secondary_green: #006838;

.btn-primary-green{
  background-color: $primary_green;
  color: #fff;

  &:hover{
    color: #fff !important;
    box-shadow: 0 0 2px solid $secondary_green;
  }
}

.loading-app-div{
  position: absolute;
  background-color: darken(#fff, 4%);
  top: 0;
  left: 0;
  z-index: 1;
}

.br-3{
   border-radius: 3px;
}

.widget-column{
 h5{
   background-color: lighten(forestgreen, 4%);
  border-radius: 3px;
 } 
}

.text-primary-green{
  color: $primary_green !important;
}

.send-to-back{
  // z-index: -10;
}

.lds-dual-ring {
  display: inline-block;
  width: 64px;
  height: 64px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 46px;
  height: 46px;
  margin: 1px;
  border-radius: 50%;
  border: 5px solid $primary_green;
  border-color: $primary_green transparent $primary_green transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.main-wrapper-container {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  padding-left: 0;
  padding-right: 0;
  width: 100%;
  // background-color: $primary_green;
}

section {
  position: relative;
}

.c-height-inherit {
  height: inherit;
}

.h-100-vh {
  height: 100vh;
}

.h-75-vh {
  min-height: 75vh;
}

.h-50-vh {
  min-height: 50vh;
}

.h-25-vh {
  min-height: 25vh;
}

.form-generic-sizing {
  width: 85%;
  transition: all 0.3s ease-in-out;

  @media screen and (min-width: 568px) {
    width: 55%;
  }

  @media screen and (min-width: 768px) {
    width: 45%;
  }

  @media screen and (min-width: 992px) {
    width: 25%;
  }

  @media screen and (min-width: 1200px) {
  }
}

h1,
h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

// li {
//   display: inline-block;
//   margin: 0 10px;
// }

a {
  color: $primary_green;
}
</style>
