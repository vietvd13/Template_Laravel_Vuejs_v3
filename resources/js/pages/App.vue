<template>
  <div id="app">
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
  created() {
    console.log('%cVehicle Management', 'font-size: 20px; padding: 5px 10px 5px 10px; border-radius: .25rem; color: #FFFFF; background-color: #FB9A09; text-align: center;');
  },
};
</script>

